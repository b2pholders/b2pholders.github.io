<script>
    const downloadSize = 'SIZE_OF_IMAGE_IN_BYTES';
    const download = new Image();

    let imageAddr = "IMAGE_URL_HERE";
    let startTime, endTime;

    imageAddr += "?n=" + Math.random();

    download.onload = function () {
        endTime = (new Date()).getTime();
        showResults();
    }

    startTime = (new Date()).getTime();
    download.src = imageAddr;

    function showResults() {
        const duration = (endTime - startTime) / 1000; //Math.round()
        const bitsLoaded = downloadSize * 8;
        const speedBps = (bitsLoaded / duration).toFixed(2);
        const speedKbps = (speedBps / 1024).toFixed(2);
        const speedMbps = (speedKbps / 1024).toFixed(2);

        if (speedMbps < 1) {
            //LOAD_SMALL_VIDEO
        } else if (speedMbps < 2) {
            //LOAD_MEDIUM_VIDEO
        } else {
            //LOAD_LARGE_VIDEO
        }
    }
</script>