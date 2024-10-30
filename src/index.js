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
const express = require('express');
const jwt = require('jsonwebtoken');

// Middleware function
function authenticateToken(req, res, next) {
  const authHeader = req.headers['authorization'];
  const token = authHeader && authHeader.split(' ')[1];

  if (token == null) return res.sendStatus(401);   
 // Unauthorized

  jwt.verify(token,   
 'your-secret-key', (err, payload) => {
    if (err) return res.sendStatus(403); // Forbidden

    req.user = payload;
    next();
  });
}

// Protected route
app.get('/protected', authenticateToken, (req, res) => {
  res.json({ message: 'You are authorized!' });
});
