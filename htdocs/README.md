# PHP Application

PHP Application for kenshu backend

## アーキテクチャ

本アプリケーションは、Clean Architecture を基に開発しています。

![cleanar](https://user-images.githubusercontent.com/79124542/116330960-9b621300-a809-11eb-920d-74fb36ccdde9.jpeg)

## ディレクトリ構成

---

```
htdocs /
    ┝ app /
    │   ┝ Adapter    <-- ControllerやPresentator, Repositoryを格納
    │   ┝ Entity     <-- Entityを格納
    │   ┝ External   <-- DBやSession, CSRF対策のコードを格納
    │   └ Usecase    <-- UsecaseとなるInteractorを格納
    │
    ┝ public         <-- Apacheの公開ディレクトリに配置するためのディレクトリ
    ┝ view           <-- 共通のコンポーネントを配置
    ┝ composer.json
    ┝ composer.lock
    └ README.md
```
