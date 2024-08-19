const axios = require('axios');

//Just for dev mode
process.env.ADMIN_KEY = 'key'

const interval = 5 * 60 * 1000;

const sendPostRequest = async () => {
  try {
    const method = 'POST'
    const url = 'http://localhost:8000/api/schedule/trigger/daily';
    const headers = { Authorization: `Bearer ${process.env.ADMIN_KEY}` }

    const response = await axios({ url, method, headers });

    console.log(`Response: ${JSON.stringify(response.data)}`);
  } catch (error) {
    console.error('Error:', error.message);
  }
};

sendPostRequest();
setInterval(sendPostRequest, interval);
