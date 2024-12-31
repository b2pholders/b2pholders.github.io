<h1 id="ticker"></h1>
<script>
    const el = document.getElementById('ticker');
    const ws = new WebSocket('wss://stream.binance.com:9443/ws/btcusdt@ticker');

    ws.addEventListener('message', e => {

        let data = JSON.parse(e.data) || {};
        let {s, c, P} = data;

        el.textContent = s + ' $' + Number(c).toFixed(2) + ' ' + Number(P).toFixed(2) + '%';
    });
</script>