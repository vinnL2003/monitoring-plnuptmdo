import fs from 'fs';

const targetSources = {
  nko_csv: "https://docs.google.com/spreadsheets/d/e/2PACX-1vSsiPTUoc4DRY6O_NLcn44tskrhiaIo6HQ0NPkl9N26ZnJYuZBSLX0zW8wawz_QyfypipvzPslRCyDV/pub?gid=1211605670&single=true&output=csv",
  ahi_csv: "https://docs.google.com/spreadsheets/d/e/2PACX-1vTp0iLO9oj0vLgBy8cSQghkV6DtmKxFnoJuvIlyenhYtOcRLBpVQYsogjV5uNApZb0E_YbO85QidQkn/pub?output=csv",
  tower_kondisi_csv: "https://docs.google.com/spreadsheets/d/e/2PACX-1vTp0iLO9oj0vLgBy8cSQghkV6DtmKxFnoJuvIlyenhYtOcRLBpVQYsogjV5uNApZb0E_YbO85QidQkn/pub?gid=1948332076&single=true&output=csv",
  asset_csv: "https://docs.google.com/spreadsheets/d/e/2PACX-1vQ7Ovm3gLoamwHFdoj8FI_bDn4peGyKvtPDJzHUIjAXMj_bzO_QVybM7I3nzVTpAxhVoz-yOi8OOumV/pub?gid=264440244&single=true&output=csv",
  gi_csv: "https://docs.google.com/spreadsheets/d/e/2PACX-1vTp0iLO9oj0vLgBy8cSQghkV6DtmKxFnoJuvIlyenhYtOcRLBpVQYsogjV5uNApZb0E_YbO85QidQkn/pub?gid=1464257596&single=true&output=csv",
  common_enemy_csv: "https://docs.google.com/spreadsheets/d/e/2PACX-1vSYXWVwCN8M7YvczPXdJ_0YpYTM8IAQHsXHdzWypCZiPOXkAx0nBG2JtMNYFu6YUTosQfU1HgCcc4Ue/pub?gid=408872963&single=true&output=csv",
  anti_blackout_csv: "https://docs.google.com/spreadsheets/d/e/2PACX-1vSYXWVwCN8M7YvczPXdJ_0YpYTM8IAQHsXHdzWypCZiPOXkAx0nBG2JtMNYFu6YUTosQfU1HgCcc4Ue/pub?gid=1190506631&single=true&output=csv",
  anggaran_csv: "https://docs.google.com/spreadsheets/d/e/2PACX-1vRx2dxv5UCa5R84BkO9cOzfUfXZ1Yr_fBTDfC_Bxn5fvXpsk6Gt2QrrAWdO_MrsIA/pub?output=csv",
  kinerja_transmisi_csv: "https://docs.google.com/spreadsheets/d/e/2PACX-1vQ7Ovm3gLoamwHFdoj8FI_bDn4peGyKvtPDJzHUIjAXMj_bzO_QVybM7I3nzVTpAxhVoz-yOi8OOumV/pub?output=csv"
};

async function testAll() {
  console.log('Testing connection to all original Google Spreadsheet CSV URLs...');
  for (const [key, url] of Object.entries(targetSources)) {
    try {
      const start = Date.now();
      const res = await fetch(url);
      const text = await res.text();
      const duration = Date.now() - start;
      const lines = text.split('\n').filter(l => l.trim().length > 0);
      console.log(`[PASS] ${key} -> Status: ${res.status}, Size: ${text.length} bytes, Lines: ${lines.length}, Time: ${duration}ms`);
    } catch (err) {
      console.error(`[FAIL] ${key} -> Error: ${err.message}`);
    }
  }
}

testAll();
