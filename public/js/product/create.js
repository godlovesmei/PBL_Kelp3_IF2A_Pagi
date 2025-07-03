// Main Image Preview Only
window.previewMainImage = function() {
  const input = document.getElementById('image');
  const preview = document.getElementById('main-image-preview');
  preview.innerHTML = '';
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = e => {
      const img = document.createElement('img');
      img.src = e.target.result;
      img.className = 'h-32 w-48 object-cover rounded border';
      preview.appendChild(img);
    };
    reader.readAsDataURL(input.files[0]);
  }
};

// Colors Dynamic Field
let colorIndex = document.querySelectorAll('#colors-wrapper input[name^="colors"]').length || 1;

window.addColor = function() {
  const wrapper = document.getElementById('colors-wrapper');
  const div = document.createElement('div');
  div.className = 'flex space-x-3 items-center mt-2';
  div.innerHTML = `
    <input type="text" name="colors[${colorIndex}][color_name]" placeholder="Color name" required
      class="w-1/3 rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
    <input type="text" name="colors[${colorIndex}][hex]" placeholder="#hexcode" pattern="^#([A-Fa-f0-9]{6})$" title="Hex format like #FFFFFF" required
      class="w-1/3 rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 color-hex-input" oninput="updateColorPreview(this)" />
    <span class="inline-block w-8 h-8 rounded border ml-1 color-preview"></span>
    <input type="text" name="colors[${colorIndex}][alt_hex]" placeholder="#alt_hex" pattern="^#([A-Fa-f0-9]{6})$" title="Hex format like #FFFFFF" required
      class="w-1/3 rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 color-hex-input" oninput="updateColorPreview(this)" />
    <span class="inline-block w-8 h-8 rounded border ml-1 color-preview"></span>
    <button type="button" onclick="removeColor(this)" class="text-red-600 font-bold text-xl px-2">&times;</button>
  `;
  wrapper.appendChild(div);
  colorIndex++;
};

window.removeColor = function(btn) {
  btn.parentElement.remove();
};

function updateColorPreview(input) {
  const preview = input.nextElementSibling;
  if (preview && preview.classList.contains('color-preview')) {
    preview.style.background = input.value;
  }
}
window.updateColorPreview = updateColorPreview;

document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.color-hex-input').forEach(input => {
    updateColorPreview(input);
  });
});
