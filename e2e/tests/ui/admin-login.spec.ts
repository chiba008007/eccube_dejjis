import { test, expect } from '@playwright/test';

test('管理画面にログインできる', async ({ page }) => {
  await page.goto('/admin/login'); // EC-CUBEのURLに合わせて変えてください

  await page.fill('input[name="login_id"]', 'admin');
  await page.fill('input[name="password"]', 'password');
  await page.click('button[type="submit"]');

  // await expect(page).toHaveURL(/.*dashboard/);
  // await expect(page.locator('h1')).toContainText('ダッシュボード');

  await expect(page).toHaveTitle(/ホーム/);
});
