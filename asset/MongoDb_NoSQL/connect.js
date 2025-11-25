const { MongoClient } = require('mongodb');
const uri = 'mongodb://localhost:27017'; // hoặc đường dẫn cloud như MongoDB Atlas
const client = new MongoClient(uri);

async function getDatabase(dbName) {
  if (!client.topology || !client.topology.isConnected()) {
    await client.connect();
  }
  return client.db(dbName);
}

module.exports = { getDatabase };
// Chạy thử để test kết nối
getDatabase('Lab3AA').then(() => {
  console.log('✅ Đã kết nối MongoDB');
}).catch(err => {
  console.error('❌ Lỗi kết nối:', err);
});
