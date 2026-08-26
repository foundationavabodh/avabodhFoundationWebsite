const express = require('express');
const path = require('path');

const app = express();
const PORT = process.env.PORT || 3000;
const PUBLIC_DIR = path.join(__dirname, 'public');

// Serve all static assets (css, js, img) and .html files directly
app.use(express.static(PUBLIC_DIR));

// Optional: clean URLs -> /about resolves to /about.html
app.get('/:page', (req, res, next) => {
  const filePath = path.join(PUBLIC_DIR, `${req.params.page}.html`);
  res.sendFile(filePath, (err) => {
    if (err) next(); // fall through to 404 handler if file doesn't exist
  });
});

// Root -> index.html (also handled by express.static, kept explicit for clarity)
app.get('/', (req, res) => {
  res.sendFile(path.join(PUBLIC_DIR, 'index.html'));
});

// 404 handler
app.use((req, res) => {
  res.status(404).sendFile(path.join(PUBLIC_DIR, '404.html'));
});

app.listen(PORT, () => {
  console.log(`Kindi site running at http://localhost:${PORT}`);
});
