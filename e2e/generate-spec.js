const fs = require('fs');
const path = require('path');

const testCode = `import { test, expect } from '@playwright/test';

test('商品を登録して廃止し、一覧に表示されなくなる', async ({ page }) => {
  const productName = 'テスト商品_' + Date.now();

  // 1. 管理画面ログイン
  await page.goto('http://localhost/admin/login');
  await page.fill('input[name="login_id"]', 'admin');
  await page.fill('input[name="password"]', 'password');
  await page.click('button[type="submit"]');

  // 2. 商品登録ページへ移動
  await page.click('text=商品管理');
  await page.click('text=商品登録');

  // 3. 商品情報を入力して登録
  await page.fill('input[name="admin_product[name]"]', productName);
  await page.fill('input[name="admin_product[class][price02]"]', '1234');
  await page.selectOption('select[name="admin_product[Status]"]', '1'); // 公開
  await page.click('button:has-text("登録")');
  await expect(page.locator('.alert-success')).toContainText('保存しました');

  // 4. 一覧に戻って商品が表示されることを確認
  await page.click('text=商品一覧');
  await expect(page.locator('table')).toContainText(productName);

  // 5. 商品詳細ページに移動
  await page.click(\`text=\${productName}\`);

  // 6. ステータスを「廃止」に変更し、保存
  await page.selectOption('select[name="admin_product[Status]"]', '3');
  await page.click('button:has-text("登録")');
  await expect(page.locator('.alert-success')).toContainText('保存しました');

  // 7. 一覧に戻り、商品が表示されないことを確認
  await page.click('text=商品一覧');
  await expect(page.locator('table')).not.toContainText(productName);
});
`;

const outputDir = path.join(__dirname, 'tests');
const outputPath = path.join(outputDir, 'product-create-delete.spec.ts');

if (!fs.existsSync(outputDir)) {
  fs.mkdirSync(outputDir);
}

fs.writeFileSync(outputPath, testCode, { encoding: 'utf8' });

console.log('✅ テストファイルを生成しました: ' + outputPath);
