// tests/mock-api.spec.ts
import { test, expect, request as playwrightRequest } from '@playwright/test';
import { createServer } from 'http'; // モック用のapiサーバーを作る
import fs from 'fs';
import path from 'path';

import * as dotenv from 'dotenv';
dotenv.config();

const host = process.env.API_HOST;
const requestBody = JSON.parse(fs.readFileSync(path.join(__dirname,'../../server/mockdata/mock-json-api-request.json'), 'utf-8' ));
const mockResponse  = JSON.parse(fs.readFileSync(path.join(__dirname,'../../server/mockdata/mock-json-api-response.json' ), 'utf-8'));

test('モックAPIにPOSTして固定レスポンスを返す', async () => {
  // Step 1: モックサーバーを立てる
  const server = createServer((req, res) => {
    if (req.method === 'POST' && req.url === '/amazonApiSample') {
      res.writeHead(200, { 'Content-Type': 'application/json' });
      res.end(JSON.stringify(mockResponse));
    } else {
      res.writeHead(404);
      res.end();
    }
  });

  await new Promise<void>((resolve) => server.listen(3356, resolve));

  // Step 2: APIリクエスト用の context を生成
  const context = await playwrightRequest.newContext();
  const response = await context.post(`${host}:3356/amazonApiSample`,
    requestBody
  );

  // Step 3: レスポンスの確認
  expect(response.status()).toBe(200);
  const json = await response.json();
  expect(json).toMatchObject(mockResponse);

  // Step 4: サーバー停止
  await new Promise<void>((resolve, reject) => {
    server.close((err) => {
      if (err) reject(err);
      else resolve();
    });
  });
});
