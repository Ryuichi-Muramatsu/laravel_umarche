
## インストール後の実施事項

画像のダミーデータは
public/imagesフォルダ内に
sample1.jpg ~ sample6.jpgとして
保存しています。

php artisan storage:linkで
storageフォルダにリンク後、

storage/app/public/productsフォルダ内に
保存すると表示されます。
（productsフォルダが無い場合は作成してください。）  

ショップの画像を表示する場合は
storage/app/public/shopsフォルダを作成し
画像を保存してください。