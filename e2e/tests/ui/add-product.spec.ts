import { test, expect } from '@playwright/test';

test('商品を登録して一覧に反映される・追加した商品を削除する', async ({ page }) => {
  const productName = 'テスト商品_' + Date.now();

  // 管理画面ログイン
  await page.goto('/admin/login');
  await page.fill('input[name="login_id"]', 'admin');
  await page.fill('input[name="password"]', 'password');
  await page.click('button[type="submit"]');

  // 商品マスターに移動
  await page.click('text=商品管理');

  // 商品追加ページへ
  await page.click('text=商品登録');

  // 商品情報を入力
  await page.fill('input[name="admin_product[name]"]', productName);
  await page.fill('input[name="admin_product[class][price02]"]', '1234');
  await page.selectOption('select[name="admin_product[Status]"]', '1'); // 公開状態

  // 登録ボタンをクリック
  await page.click('button:has-text("登録")');

  // 成功メッセージを確認
  await expect(page.locator('.alert-success')).toContainText('保存しました');
  // 一覧に戻って商品名があることを確認
  await page.click('text=商品一覧'); // 一覧に戻る
  await expect(page.locator('table')).toContainText(productName);

   // 商品詳細ページに移動
  await page.click(`text=${productName}`);
  // ステータスを「廃止」に変更し、保存
  await page.selectOption('select[name="admin_product[Status]"]', '3'); // 廃止
  await page.click('button:has-text("登録")');
  await expect(page.locator('.alert-success')).toContainText('保存しました');

  await page.click('text=商品一覧'); // 一覧に戻る
  await expect(page.locator('table')).not.toContainText(productName);


});
