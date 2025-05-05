<template>
    <div class="floating-menu">
      <button class="floating-button" @click="callAction">
        <img src="phone-icon.svg" alt="Call" />
      </button>
      <button class="floating-button" @click="openLocation">
        <img src="location-icon.svg" alt="Location" />
      </button>
      <button class="floating-button" @click="startChat">
        <img src="chat-icon.svg" alt="Chat" />
      </button>
    </div>
  </template>
  
  <script>
  export default {
    methods: {
      callAction() {
        alert("Calling...");
      },
      openLocation() {
        alert("Opening location...");
      },
      startChat() {
        alert("Starting chat...");
      },
    },
  };
  </script>
  
  <style scoped>
  .floating-menu {
    position: fixed;
    bottom: 20px;
    right: 20px;
    display: flex;
    flex-direction: column;
    gap: 10px;
  }
  
  .floating-button {
    background-color: white;
    border-radius: 50%;
    padding: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
  }
  
  .floating-button:hover {
    transform: scale(1.1);
  }
  </style>