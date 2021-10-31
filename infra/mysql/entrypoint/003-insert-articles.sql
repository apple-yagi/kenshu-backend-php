USE kenshudb;

INSERT INTO articles
  (id, title, body, user_id)
VALUES
  (1, 'article01', 'これは、user01が投稿した記事です。', 1),
  (2, 'article02', 'これは、user02が投稿した記事です。', 2),
  (3, 'article03', 'これは、user03が投稿した記事です。', 3);