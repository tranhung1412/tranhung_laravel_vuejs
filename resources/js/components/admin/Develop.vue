<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <div v-if="success !== ''" class="alert alert-success" role="alert">
                        {{success}}
                    </div>
                    <label>Product image</label>
                    <div class="custom-file" >
                        <div>
                        <input type="file" @change="getImage" ref="file" name="file[]" multiple>
                        <a href="#" class="btn btn-success" @click.prevent="upload">Upload</a>
                            <button class="btn btn-success" @click.prevent="clearImage">Clear</button>
                        </div>
                        <span  v-for="(img, index) in listImage" :key="index"><img :src="img" alt="" style="height: 80px; height: 80px;margin-top:30px"></span>
                             
                    </div>
                   
                </div>
            </div>
             
        </div>
    </div>
</template>

<script>
    export default {
        name: "Develop",
        data(){
            return{
                listImage: [],
                avatar: '',
                filename: null,
                file:[],
                success: '',
                data:'',
            }
        },
        methods:{
            getImage(e){
                // let image = e.target.files[0];
                // this.file = image;
                // this.filename = "Selected File: " + e.target.files[0].name;
                // let reader = new FileReader();
                // reader.readAsDataURL(image);
                // reader.onload = e => {
                //     this.avatar = e.target.result;
                // }
                let image = this.$refs.file.files;
                var currrent = this;
               
                for(let i=0;i<image.length;i++){
                    let reader = new FileReader();
                    reader.readAsDataURL(image[i]);
                    reader.onload = e => {
                        currrent.avatar = e.target.result;
                         currrent.listImage.push(currrent.avatar);
                    }
                      console.log(this.avatar);
                     
                }
              
            },
            upload(e){
                const config = {
                    headers: {
                        'content-type': 'multipart/form-data',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    }
                };
                let formData = new FormData();
                let image =this.$refs.file.files;
                this.file = image;
                for(let i=0;i<image.length;i++){
                    formData.append('file[]',image[i]);
                }
                console.log(formData);
                // form data
                // let formData = new FormData();
                // formData.append('file', this.file);

                // send upload request
                axios.post('/api/upload', formData, config)
                .then(response => {
                    console.log(response.data.data);
                    this.data = response.data.data;
                    //this.filename = "";
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            clearImage(){
                this.avatar = "";
                console.log("aaaaa");
                this.listImage = [];
            }

        }
    }
</script>

<style scoped>

</style>
