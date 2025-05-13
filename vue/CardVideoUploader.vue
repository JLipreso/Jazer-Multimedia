<template>
  <div class="card">
    <video :src="video.coverPicked" controls></video>
    <div class="card-body">
      <p class="text-center">{{ instruction }}</p>
        <input id="file-video" class="d-none" type="file" ref="file" @change="loadImage($event)" accept="video/*"/>
        <div class="w-100">
          <button class="btn btn-outline-primary py-2 w-100 d-flex justify-content-center align-items-center" type="button"  data-dismiss="modal" @click="openPhotoChooser()" :disabled="loading" >
            <i class="bi bi-camera-reels-fill me-2"></i>
            <span> {{ loading ? 'Uploading...':'Select Video to upload' }}</span>
          </button>
        </div>
    </div>
  </div>
</template>
<script lang="ts">

  import { defineComponent } from 'vue';
  import * as $ from 'jquery';
  import { variable } from '@/var';
  import axios from 'axios';
  import Swal from 'sweetalert2';

  export default defineComponent({
    emits: ['uploaded', 'fail'],
    props: {
      btn_upload_text: {
        default: 'Upload',
        type: String
      },
      instruction: {
        default: 'Upload photo with png, jpg, jpeg file extensions.',
        type: String
      }
    },
    components: { },
    data() {
      return {
        loading: false,
        video: {
          coverPicked: "" as any,
        },
      }
    },
    methods: {
      async openPhotoChooser() {
        (this.$refs['file'] as any).click();
      },
      async loadImage(event: any) {
        var input = event.target;
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = (e) => {
            this.video.coverPicked = e?.target?.result;
          }
          reader.readAsDataURL(input.files[0]);

          const formData = new FormData();
          formData.append("image", input.files[0]);
          this.loading = true;
          await axios.post( variable()['api_main'] + "photo/uploadFunct", formData, { headers: {'Content-Type': 'multipart/form-data'}}).then( async (response) => {
            this.loading = false;
            if(response.data?.success) {
              this.$emit('uploaded', { data: response.data?.data });
            }
            else {
              this.$emit('fail');
            }
          });
        }
      }
    }
  });

</script>
<style scoped>
  video {
    width: 100%;
    min-height: 250px
  }
</style>