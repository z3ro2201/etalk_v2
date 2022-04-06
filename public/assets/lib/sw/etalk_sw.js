// 캐시 이름
const CACHE_NAME = "cache-v1";

// 캐싱할 파일
const FILES_TO_CACHE = [
    "/offline.html",
    "/assets/lib/manifest.json",
    "/assets/css/globalEtalk.v2.css",
    "/assets/icons/etalk_128x128.png",
    "/assets/icons/etalk_144x144.png",
    "/assets/icons/etalk_152x152.png",
    "/assets/icons/etalk_192x192.png",
    "/assets/icons/etalk_256x256.png",
    "/assets/icons/etalk_512x512.png",
    "/assets/lib/bootstrap/css/bootstrap.min.css",
    "/assets/lib/jquery/jquery.min.js"
];

// 상술한 파일 캐싱
self.addEventListener("install", (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => cache.addAll(FILES_TO_CACHE))
    );
});

// CACHE_NAME이 변경되면 오래된 캐시 삭제
self.addEventListener("activate", (event) => {
    event.waitUntil(
        caches.keys().then((keyList) =>
            Promise.all(
                keyList.map((key) => {
                    if (CACHE_NAME !== key) return caches.delete(key);
                })
            )
        )
    );
});

// 요청에 실패하면 오프라인 페이지 표시
self.addEventListener("fetch", (event) => {
    if ("navigate" !== event.request.mode) return;

    event.respondWith(
        fetch(event.request).catch(() =>
            caches
                .open(CACHE_NAME)
                .then((cache) => cache.match("/offline.html"))
        )
    );
});