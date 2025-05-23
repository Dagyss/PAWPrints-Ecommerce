export function delay(ms) {
  return new Promise((res) => setTimeout(res, ms));
}

export async function preloadImages(imageSources, path = "", container) {
  let loaded = 0;
  const total = imageSources.length;

  const { progressBarContainer, progressBar } = creatingProgressBar(container);
  const loadedImages = [];

  for (const src of imageSources) {
    const img = await simulateLoadImage(path + src, 150);

    loadedImages.push(img);
    loaded++;

    const percent = Math.round((loaded / total) * 100);
    progressBar.innerText = `Cargando ${percent}%`;
    progressBar.style.width = `${percent}%`;
  }

  await delay(200);
  progressBarContainer.style.display = "none";
  return loadedImages;
}

function simulateLoadImage(src, fakeDelay = 300) {
  return new Promise((resolve, reject) => {
    const img = new Image();
    img.src = src;

    img.onload = () => {
      setTimeout(() => resolve(img), fakeDelay);
    };

    img.onerror = () => {
      setTimeout(
        () => reject(new Error(`No se pudo cargar ${src}`)),
        fakeDelay
      );
    };
  });
}

function creatingProgressBar(container) {
  container.innerHTML = `
      <div class="progress-bar-container" aria-hidden="true">
          <div class="progress-bar"></div>
      </div>
    `;
  return {
    progressBarContainer: container.querySelector(".progress-bar-container"),
    progressBar: container.querySelector(".progress-bar"),
  };
}
