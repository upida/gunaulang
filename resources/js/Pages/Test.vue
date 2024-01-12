<template>
    <v-app>
      <v-container>
        <v-row>
          <v-col>
            <!-- v-img sebagai latar belakang -->
            <v-img
              src="https://images.tokopedia.net/img/cache/600/bjFkPX/2023/6/21/40d72aac-c7a3-4a68-8737-c19a1c8e9c6c.jpg.webp"
              aspect-ratio="2.5"
              cover
              class="d-flex align-end"
            >
              <!-- v-btn di atas v-img -->
              <v-btn @click="handleButtonClick" color="primary">
                Tombol Saya
              </v-btn>
            </v-img>
          </v-col>
        </v-row>
      </v-container>
    </v-app>
  </template>
  
  <script>
  export default {
    methods: {
      handleButtonClick() {
        // Logika yang akan dijalankan saat tombol diklik
        console.log('Tombol diklik!');
      },
    },
  };
  </script>
  
  <style scoped>
  /* Gaya CSS untuk menyesuaikan tata letak */
  .d-flex {
    display: flex;
  }
  
  .align-end {
    align-items: flex-end;
  }
  
  /* Atur posisi tombol */
  v-btn {
    position: relative;
    top: -50px; /* Sesuaikan sesuai kebutuhan Anda */
  }
  </style>
  