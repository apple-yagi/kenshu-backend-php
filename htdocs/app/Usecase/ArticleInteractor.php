<?php

namespace App\Usecase;

use App\Adapter\Controllers\DTO\Article\CreateArticleDto;
use App\Adapter\Controllers\DTO\Article\UpdateArticleDto;
use App\Adapter\Repositories\Interfaces\iArticleRepository;
use App\Adapter\Repositories\Interfaces\iArticleTagRepository;
use App\Adapter\Repositories\Interfaces\iPhotoRepository;
use App\Adapter\Uploaders\Interfaces\iPhotoUploader;
use App\Entity\Article;
use App\Entity\Photo;
use App\Entity\Tag;
use Exception;

class ArticleInteractor
{
  protected iArticleRepository $articleRepository;
  protected ?iPhotoRepository $photoRepository;
  protected ?iPhotoUploader $photoUploader;
  protected ?iArticleTagRepository $articleTagRepository;

  function __construct(iArticleRepository $ar, iPhotoRepository $pr = null, iPhotoUploader $pu = null, iArticleTagRepository $atr = null)
  {
    $this->articleRepository = $ar;
    $this->photoRepository = $pr;
    $this->photoUploader = $pu;
    $this->articleTagRepository = $atr;
  }

  public function findAll(): array
  {
    return $this->articleRepository->findAll();
  }

  public function findById(int $id): ?Article
  {
    $array = $this->articleRepository->findById($id);

    if (!$array) {
      return null;
    }

    $article = new Article((object) $array[0]);
    $photos = array();
    $tags = array();

    foreach ($array as $record) {
      if ($record["photo_url"]) {
        $record["id"] = $record["photo_id"];
        $record["url"] = $record["photo_url"];
        array_push($photos, new Photo((object) $record));
      }

      if ($record["tag_id"]) {
        $record["id"] = $record["tag_id"];
        $record["name"] = $record["tag_name"];
        array_push($tags, new Tag((object) $record));
      }
    }

    $article->setPhotos(array_unique($photos));
    $article->setTags(array_unique($tags));
    return $article;
  }

  public function save(CreateArticleDto $createArticleDto): int
  {
    $createArticle = new Article($createArticleDto);

    // トランザクション開始
    $this->articleRepository->beginTransaction();
    try {
      $createArticleId = $this->articleRepository->save($createArticle);
      if (!$createArticleId) {
        throw new Exception("記事の登録に失敗しました");
      }

      // 記事に画像が付与されている時
      if (!empty($createArticle->photos["name"][0])) {
        // 画像をアップロード
        $photoUrlList = [];
        $photos = $createArticle->photos;
        for ($i = 0; $i < count($photos["name"]); $i++) {
          $this->photoUploader->setPhotoInfo($createArticleId, $photos["tmp_name"][$i], $photos["name"][$i]);
          $uploadResult = $this->photoUploader->upload();
          if (!$uploadResult) {
            throw new Exception("画像のアップロードに失敗しました");
          }
          array_push($photoUrlList, $uploadResult);
        }

        // アップロードされた画像をDBに登録
        $photoInsertResult = $this->photoRepository->saveValues($createArticleId, $photoUrlList);
        if (!$photoInsertResult) {
          throw new Exception("画像の登録に失敗しました");
        }

        // DBに登録された画像のIDを記事のサムネイルに登録
        $articleUpdateResult = $this->articleRepository->updateThumbnailId($createArticleId, $photoInsertResult);
        if (!$articleUpdateResult) {
          throw new Exception("サムネイルの設定に失敗しました");
        }
      }

      // 記事にタグが付与されている時
      if (!empty($createArticle->tags[0])) {
        // articles_tagsテーブルに保存
        $tagInsertResult = $this->articleTagRepository->saveValues($createArticleId, $createArticle->tags);
        if (!$tagInsertResult) {
          throw new Exception("タグの関連づけに失敗しました");
        }
      }

      // コミット
      $this->articleRepository->commit();

      return $createArticleId;
    } catch (Exception $e) {
      // ロールバック
      $this->articleRepository->rollBack();
      $this->photoUploader->rollBack();
      throw $e;
    }
  }

  public function update(UpdateArticleDto $updateArticleDto): bool
  {
    $article = new Article($updateArticleDto);
    return $this->articleRepository->update($article);
  }

  public function delete(int $id): bool
  {
    return $this->articleRepository->delete($id);
  }
}
