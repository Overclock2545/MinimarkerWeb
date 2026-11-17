(() => {
  const element = document.getElementById('referral-code');
  if (!element) return;
  try {
    const code = JSON.parse(element.textContent);
    if (/^[a-f0-9]{32}$/.test(code)) sessionStorage.setItem('b2-referral', code);
  } catch (_) {}
})();
