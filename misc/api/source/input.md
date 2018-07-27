FORMAT: 1A

# Group API

## 画像に対する処理 [/v1/images{?cursol}]

### 複数件取得する [GET]

+ Parameters
  + cursol: 10 (number, optional) - 指定したデータIDから先を取得する
+ Response 200 (application/json)

  + Attributes (Images)
      + success: true (boolean)

### 投稿する [POST]

+ Request (multipart/form-data)

  + Attributes
      + name: サンプル画像 (string) - ファイル名称
      + file: filedata - ファイルバイナリデータ

+ Response 201 (application/json)

  + Attributes
      + success: true (boolean, required)
      + redirectTo: / (string)

## 指定画像に対する処理 [/v1/images/{id}]

+ Parameters
  + id: 10 (number) - 対象データID

### 指定した画像を取得する [GET]

+ Response 200 (application/json)

  + Attributes (ImageDetail)
      + id: 10 (number)
      + success: true (boolean)

### 削除する [DELETE]

+ Response 202 (application/json)

  + Attributes
      + success: true (boolean, required)
      + redirectTo: / (string)

## Data Structure

### Images

+ items (array, fixed)
  + (Image)
      + id: 1(number)
  + (Image)
      + id: 2(number)
  + (Image)
      + id: 3(number)

### Image (object)

+ id: 1 (number, required)
+ name: サンプル画像 (string, required)
+ url: http://via.placeholder.com/360x480 (string, required)

### ImageDetail (object)

+ id: 1 (number, required)
+ name: サンプル画像 (string, required)
+ url: http://via.placeholder.com/360x480 (string, required)
+ addAt: 20141010T045040Z (string) - 投稿日時。ISO8601表記
+ editAt: 20151010T045040Z (string) - 編集日時。ISO8601表記
+ author_id: 10 (number) - 投稿者ID
+ author_ip: 124.33.33.33, 20.33.44.55 (string) - 投稿者IP
