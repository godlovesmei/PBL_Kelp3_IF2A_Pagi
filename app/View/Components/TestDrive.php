<button class="test-drive-btn">
  <span class="arrow left-arrow">←</span>
  TEST DRIVE
  <span class="arrow right-arrow">→</span>
</button>
<style>
  /* Styling untuk tombol Test Drive */
.test-drive-btn {
  display: inline-flex;
  align-items: center;
  background-color: red;
  color: white;
  font-size: 16px;
  font-weight: bold;
  padding: 10px 20px;
  border: none;
  border-radius: 30px;
  cursor: pointer;
  position: relative;
  overflow: hidden;
}

/* Menambahkan animasi kedap kedip pada panah */
.arrow {
  font-size: 20px;
  opacity: 0;
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  animation: blink 1s infinite;
}

.left-arrow {
  left: 10px;
  animation-delay: 0s; /* Animasi untuk panah kiri */
}

.right-arrow {
  right: 10px;
  animation-delay: 0.5s; /* Animasi untuk panah kanan */
}

/* Efek animasi kedap kedip */
@keyframes blink {
  0% {
    opacity: 0;
  }
  50% {
    opacity: 1;
  }
  100% {
    opacity: 0;
  }
}

@keyframes blink {
  0% {
    opacity: 0;
    transform: translateX(-10px); /* Menggeser panah sedikit */
  }
  50% {
    opacity: 1;
    transform: translateX(0); /* Panah kembali ke posisi normal */
  }
  100% {
    opacity: 0;
    transform: translateX(10px); /* Menggeser panah ke kanan */
  }
}

</style>