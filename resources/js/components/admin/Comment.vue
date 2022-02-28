<template>
    <div>
        <!-- <button class="btn btn-outline-success float-right" data-toggle="modal"
                data-target="#exampleModal" @click="openAddCategory()">Add category
        </button> -->
        <h2 class="text-center mb-3">All comment</h2>
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Chủ đề</th>
                <th scope="col">Content</th>
                <th scope="col">Created At</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>

            <tr v-for="(comment, index) in comments" :key="`${index}-${comment.id}`">
                <th scope="row">{{index+1}}</th>
                <td>{{comment.user.name}}</td>
                <td>{{comment.product.name}}</td>
                <td>{{comment.noidung}}</td>
                <td>{{comment.created_at | myDate}}</td>
                <td>
                    <div class="btn-group">
                        <button
                            class="btn btn-outline-warning"
                            data-target="#exampleModal"
                            data-toggle="modal"
                            @click="getCommentById(comment)">reply
                        </button>
                        <button
                            @click="deleteComment(comment.id, index)"
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
                        <h5 class="modal-title text-success">Reply Comment</h5>
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="postComment">
                        <div class="modal-body">

                            <div class="form-group">
                                <label>Comment Content</label>
                                <ckeditor  v-model="form.content" name="content"></ckeditor>
                                <has-error :form="form" field="content"></has-error>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">Close
                            </button>
                            <button type="submit" class="btn btn-primary">Send Reply
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
        name: "Comment",
        data() {
            return {

                editMode: false,
                //categories: [],
                comments:[],
                form: new Form({
                    id: '',
                   content:'',
                }),
                // error: null,
                
            }
        },
        methods: {
            openAddCategory(){
                this.editMode = false;
                this.form.reset();
            },
            postComment(){
                this.form.post('/api/commentAdmin/'+this.form.id, this.form)
                .then(function (response) {
                    console.log(response);
                    Toast.fire({
                        icon: 'success',
                        title: response.data.message
                    });
                    $('#exampleModal').modal('hide');
                    Fire.$emit('afterSaveChange');
                })
                .catch(function (error) {
                    console.log(error);
                })
            },
            getAllComment() {
                axios.get('/api/getAllComment')
                .then(response => {
                    console.log(response.data.comment);
                    this.comments = response.data.comment;
                })
            },
            deleteComment(id, index) {
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
                        axios.delete('/api/deleteComment/' + id)
                        .then(function (resp) {
                            app.comments.splice(index, 1);
                            console.log(resp)
                        })
                        .catch(function (resp) {
                            alert("Could not delete company");
                            console.log(resp)
                        });
                    }

                })

            },
            getCommentById(comment) {
                this.editMode = true;
                this.form.clear();
                $('#exampleModal').modal('show');
                this.form.fill(comment);
            },
        },
        created() {
            this.getAllComment();
            //this.getAllCategory();
            Fire.$on('afterSaveChange', ()=>{
                this.getAllComment();
            });
           
            //setInterval(()=>this.getAllCategory(), 5000);
        }
    }
</script>

<style scoped>

</style>
