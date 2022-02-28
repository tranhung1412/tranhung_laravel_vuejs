<template>
    <div>
        <router-link to="/admin/add-blog">
            <button class="btn btn-outline-success float-right" data-toggle="modal"
                    data-target="#exampleModal">Add blog
            </button>
        </router-link>
        <h2 class="text-center mb-3">All comment</h2>
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Title</th>
                <th scope="col">Slug</th>
                <th scope="col">Content</th>
                <th scope="col">Image</th>
                <th scope="col">Created At</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>

            <tr v-for="(blog, index) in blogs" :key="`${index}-${blog.id}`">
                <th scope="row">{{index+1}}</th>
                <td>{{blog.title}}</td>
                <td>{{blog.slug}}</td>
                <td ><read-more more-str="" :text="blog.content" :max-chars=20></read-more></td>
                <td v-if="blog.image.length > 0">
                        <img :src="blog.image" style="width: 50px; height: 50px">
                    </td>
                <td v-else>
                    <img src="../../../../../public/assets/customer/fashi/img/no-image.jpg" alt=""
                         style="width: 50px; height: 50px">
                </td>
                <td>{{blog.created_at | myDate}}</td>
                <td>
                    <div class="btn-group">
                        <router-link
                            :to="{name: 'edit-blog', params:{id: blog.id}}"
                            class="btn btn-outline-warning">Edit
                        </router-link>
                        <button
                            @click="deleteBlog(blog.id, index)"
                            class="btn btn-outline-danger">Delete
                        </button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-if="editMode" class="modal-title text-success">Edit
                            blog</h5>
                        <h5 v-else class="modal-title text-success">Add
                            blog</h5>
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form  @submit.prevent="editMode ? updateBlog() : addBlog()">
                        <div class="modal-body">

                            <div class="form-group">
                                <input type="text" name="title" v-model="form.title"
                                    placeholder="Enter Title"
                                    class="form-control">    
                            </div>
                            <div class="form-group">
                                <input type="text" name="slug" v-model="form.slug"
                                    placeholder="Enter Slug"
                                    class="form-control">    
                            </div>
                            <div class="form-group">
                                <label>Blog Content</label>
                                <ckeditor :config="editorConfig"  v-model="form.content"></ckeditor>
                                <has-error :form="form" field="content"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Blog Image</label>
                                    <div>
                                        <input type="file" @change="getImage" ref="file" name="file[]" multiple >
                                        <button class="btn btn-success" @click.prevent="clearImage">Clear</button>
                                    </div>
                                    <div v-if="this.UploadImage.length < 1">
                                        <span>
                                            <img :src="Image" alt="" style="height: 80px; height: 80px;margin-top:30px">
                                        </span>
                                    </div>  
                                    <div v-if="this.UploadImage.length > 0">
                                        <span>
                                            <img :src="UploadImage" alt="" style="height: 80px; height: 80px;margin-top:30px">
                                        </span>
                                    </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">Close
                            </button>
                            <button type="submit" class="btn btn-primary">Save change
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Blog",
        data() {
            return {
                editMode: false,
                blogs:[],
                Image: [],
                blogData:'',
                UploadImage: [],
                avatar:null,
                filename: null,
                file:'',
                success: '',
                form: new Form({
                    id: '',
                    title:'',
                    slug:'',
                    content:'',
                }),
                // error: null,
                 editorConfig: {
                    // The configuration of the editor.
                    filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                    filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
                    filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
                    filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token=',
                    autoEmbed_widget: 'customEmbed'
                }
                
            }
        },
        methods: {
            // openBlog(){
            //     this.editMode = false;
            //     this.form.reset();
            //     this.clearImage();
            // },
             getImage(e){
                let image =  this.$refs.file.files[0];
                var current = this;
                let reader = new FileReader();
                reader.readAsDataURL(image);
                reader.onload = e => {
                    this.avatar = e.target.result;
                    current.UploadImage.push(current.avatar);

                }
            },
             clearImage(){
                this.avatar = "";
                console.log("aaaaa");
                this.UploadImage = [];
                this.Image = [];
                this.$refs.file.type='text';
                this.$refs.file.type='file';
            },
             getBlogById(blog) {
                 this.editMode = true;
                axios.get('/api/getBlogById/' +blog.id)
                .then(response => {
                    console.log(response.data[0]);
                    this.blogData = response.data[0];
                    this.form.fill(this.blogData);
                    this.Image = this.blogData.image;
                });
            },


            getAllBlog() {
                axios.get('/api/getAllBlog')
                .then(response => {
                    console.log(response.data.blog);
                    this.blogs = response.data.blog;
                })
            },
            deleteBlog(id, index) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                        var app = this;
                        axios.delete('/api/deleteBlog/' + id)
                        .then(function (resp) {
                            Fire.$emit('loadBlog');
                            console.log(resp);

                        })
                        .catch(function (resp) {
                            console.log(resp)
                        });
                    }

                })

            },
           
        },
        created() {
            this.getAllBlog();
            Fire.$on('loadBlog', ()=>{
                this.getAllBlog();
            });
            //setInterval(()=>this.getAllCategory(), 5000);
        }
    }
</script>

<style scoped>

</style>
