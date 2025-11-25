const { getDatabase } = require('./connect.js');

async function taoMovieWebsite() {
  const db = await getDatabase('MovieWebsite');
  await db.collection('Test').insertOne({ active: true });
  console.log('✅ MovieWebsite đã được tạo!');
}
taoMovieWebsite();