import fs from 'fs';
import path from 'path';

const dir = 'c:/kevin/Magang/Web 1/UPT-Manado';
const files = fs.readdirSync(dir).filter(f => f.endsWith('.html'));

for (const f of files) {
  const content = fs.readFileSync(path.join(dir, f), 'utf8');
  console.log(`\n================== ${f} ==================`);
  
  // Look for variables or constants like CSV_URL, SHEET_URL, URL, etc.
  const lines = content.split('\n');
  lines.forEach((line, idx) => {
    if (line.includes('CSV_URL') || line.includes('SHEET_URL') || line.includes('docs.google.com') || (line.includes('csv') && line.includes('http')) || line.includes('Papa.parse')) {
      console.log(`Line ${idx+1}: ${line.trim()}`);
    }
  });
}
