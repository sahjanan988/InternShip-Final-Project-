const express = require('express');
const app = express();
const cors = require('cors');
const dotenv = require('dotenv');
// Load environment variables from .env file
dotenv.config(); 
const port = process.env.PORT || 3306;
// Enable CORS
app.use(cors());
CD 
// Define routes
app.get('/', (req, res) => {
    res.send('Hello from Express.js!');
});

// Start the server
app.listen(port, () => {
    console.log(`Server listening on port ${port}`);
});
const Sequelize = require('sequelize');
const sequelize = new Sequelize(process.env.DATABASE_URL);

