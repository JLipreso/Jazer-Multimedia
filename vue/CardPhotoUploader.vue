<template>
  <div class="card">
    <Cropper class="cropper" 
      :src="photo.coverPicked" 
      :auto-zoom="false" 
      :stencil-props="{ aspectRatio: 10/6, movable: true, resizable: true}" 
      image-restriction="none"
      ref="cropper"
      :canvas="{
        fillColor: 'white'
      }"
    />
    <div class="card-body">
      <p>{{ instruction }}</p>
        <input class="d-none" type="file" ref="file" @change="loadImage($event)" accept="image/*"/>
        <div class="row">
          <div class="col-6">
            <button class="btn btn-outline-primary py-2 w-100 d-flex justify-content-center align-items-center" type="button"  data-dismiss="modal" @click="openPhotoChooser()">
              <i class="bi bi-file-image me-2"></i>
              <span>Select Photo</span>
            </button>
          </div>
          <div class="col-6">
            <button class="btn btn-primary py-2 w-100 d-flex justify-content-center align-items-center" type="button"  data-dismiss="modal" @click="upload()">
              <i class="bi bi-cloud-upload-fill me-2"></i>
              <span>{{ btn_upload_text }}</span>
            </button>
          </div>
        </div>
    </div>
  </div>
</template>
<script lang="ts">

  import { defineComponent } from 'vue';
  import { Cropper } from 'vue-advanced-cropper';
  import * as $ from 'jquery';
  import 'vue-advanced-cropper/dist/style.css';
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
    components: { Cropper },
    data() {
      return {
        photo: {
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
            this.photo.coverPicked = e?.target?.result;
            console.log("TEST:",this.$data);
          }
          reader.readAsDataURL(input.files[0]);
        }
      },
      upload() {
        const canvas          = (this.$refs['cropper'] as any).getResult();
        if (canvas) {
          const form = new FormData();
          canvas?.canvas?.toBlob( async (blob: Blob) => {
            form.append("image", blob);
            await axios.post( variable()['api_main'] + "photo/uploadFunct", form, { headers: {'Content-Type': 'multipart/form-data'}}).then( async (response) => {
              if(response.data?.success) {
                this.$emit('uploaded', { data: response.data?.data });
              }
              else {
                this.$emit('fail');
              }
            });
          }, "image/png");
        }
      }
    }
  });

</script>
<style scoped>
  .cropper {
    height: 320px;
    background: dimgray;
  }
</style>