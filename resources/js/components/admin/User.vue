<template>
    <div>
        <button class="btn btn-outline-success float-right" data-toggle="modal"
                data-target="#exampleModal" @click="openUser()">Add User
        </button>
        <h2 class="text-center mb-3">All User</h2>
        <div class="d-flex justify-content-end">
            <p style="padding: 10px">Hiển thị số sản phẩm</p>
            <select style="width: 10%" class="form-control" v-model="itemPerPage" @change="getAllUser(itemPerPage)"
                    :class="{ 'is-invalid': form.errors.has('idCategory') }">
                <option v-for="(item, index) in numPerPageList" :key="index" :value="item">{{item}}</option>
            </select>
        </div>
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Created At</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>

            <tr v-for="(user, index) in users.data" :key="`${index}-${user.id}`">
                <th scope="row">{{index+1}}</th>
                <td>{{user.name}}</td>
                <td>{{user.email}}</td>
                <td>{{user.created_at | myDate}}</td>
                <td>
                    <div class="btn-group">
                        <button
                            class="btn btn-outline-warning"
                            data-target="#exampleModal"
                            data-toggle="modal"
                            @click="getUserById(user)">Edit
                        </button>
                        <button
                            @click="deleteUser(user.id, index)"
                            class="btn btn-outline-danger">Delete
                        </button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            <pagination style="width: auto" class="text-center mb-3" :data="users" @pagination-change-page="getResults"></pagination>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-if="editMode" class="modal-title text-success">Edit User</h5>
                        <h5 v-else class="modal-title text-success">Add User</h5>
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form @submit.prevent="editMode ? updateUser() : addUser()">
                        <div class="modal-body">

                            <div class="form-group">
                                <label>Name</label>
                                <input v-model="form.name" type="text" name="name"
                                       class="form-control"
                                       :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input v-model="form.email" type="text" name="email"
                                       class="form-control"
                                       :class="{ 'is-invalid': form.errors.has('email') }">
                                <has-error :form="form" field="email"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input v-model="form.password" type="text" name="password"
                                       class="form-control"
                                       :class="{ 'is-invalid': form.errors.has('password') }">
                                <has-error :form="form" field="password"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Re_Password</label>
                                <input v-model="form.re_password" type="text" name="re_password"
                                       class="form-control"
                                       :class="{ 'is-invalid': form.errors.has('re_password') }">
                                <has-error :form="form" field="re_password"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Role</label>
                                <select class="form-control" id="exampleFormControlSelect1" v-model="form.roleId" name="role"
                                        :class="{ 'is-invalid': form.errors.has('role') }">
                                    <option :value=-1>----- Select a role -----</option>
                                    <option v-for="(role, index_role) in roles" :key="index_role" :value="role.id">{{role.name}}</option>
                                </select>
                                <has-error :form="form" field="idCategory"></has-error>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">Close
                            </button>
                            <button type="submit" class="btn btn-primary">Save
                                changes
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
       name: "User",
        data() {
            return {
                editMode: false,
                users:{},
                roles:[],
                form: new Form({
                    id: '',
                    name: '',
                    email: '',
                    password: '',
                    re_password: '',
                    role:[],
                    roleId: -1,
                }),
                itemPerPage: 2,
                numPerPageList: [
                    2,
                    3,
                    10
                ],
                
            }
        },
        methods: {
            openUser(){
                this.editMode = false;
                this.form.reset();
        
            },
            getAllUser() {
                axios.get('/api/getAllUser/'+this.itemPerPage)
                .then(response => {
                    console.log(response.data);
                    this.users = response.data;
                })
            },
             getUserById(user) {
                this.editMode = true;
                this.form.clear();
                $('#exampleModal').modal('show');
                this.form.fill(user);
            
            },
            getAllRole() {
                axios.get('/api/getAllRole')
                .then(response => {
                    console.log(response.roles);
                    this.roles = response.data.roles;
                })
            },
            getResults(page = 1){
                var num = this.itemPerPage;
                var url;
                if (this.$store.state.search == null){
                    url = '/api/getAllUser/'+num+'?page=' + page;
                }else {
                    url = '/api/search/'+num+'?page=' + page + "&q="+this.$store.state.search;
                }
                axios.get(url)
                .then(response => {
                    console.log(response.data);
                    this.users = response.data;
                })
            },
            addUser() {
                const config = {
                    headers: {
                        'content-type': 'multipart/form-data',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    }
                };
                 var current = this;
                 this.form.post('/api/registerAdmin', this.form, config)
                .then(function (response) {
                    console.log(response);
                    Toast.fire({
                        icon: 'success',
                        title: response.data.message
                    });
                    $('#exampleModal').modal('hide');
                    Fire.$emit('loadUser');
                })
                .catch(function (error) {
                    console.log(error);
                })
            },
            updateUser() {
                const config = {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    }
                };
                this.form.post('/api/editUserAdmin/'+this.form.id,config)
                .then(function (response) {
                    console.log(response);
                    Toast.fire({
                        icon: 'success',
                        title: 'update successfully'
                    });
                    $('#exampleModal').modal('hide');
                    Fire.$emit('loadUser');
                })
                .catch(function (error) {
                    console.log(error);
                })
            },
            deleteUser(id, index) {
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
                        axios.delete('/api/deleteUserAdmin/' + id)
                        .then(function (resp) {
                            app.users.splice(index, 1);
                            console.log(resp)
                        })
                        .catch(function (resp) {
                            console.log(resp)
                        });
                    }

                })

            },
        },
        created() {
            this.getAllUser();
            this.getAllRole();
            Fire.$on('loadUser', ()=>{
                this.getAllUser();
            });
           
            // setInterval(()=>this.getAllCategory(), 5000);
        }
    }
</script>

<style scoped>

</style>
