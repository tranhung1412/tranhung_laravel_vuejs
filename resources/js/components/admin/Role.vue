<template>
    <div>
        <button class="btn btn-outline-success float-right" data-toggle="modal"
                data-target="#exampleModal" @click="openRole()">Add Role
        </button>
        <h2 class="text-center mb-3">All Role</h2>
        <!--<div class="d-flex justify-content-end">-->
            <!--<p style="padding: 10px">Hiển thị số quyền</p>-->
            <!--<select style="width: 10%" class="form-control" v-model="itemPerPage" @change="getAllProductType(itemPerPage)"-->
                    <!--:class="{ 'is-invalid': form.errors.has('idCategory') }">-->
                <!--<option v-for="(item, index) in numPerPageList" :key="index" :value="item">{{item}}</option>-->
            <!--</select>-->
        <!--</div>-->
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Created At</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>

            <tr v-for="(role, index) in roles" :key="`${index}-${role.id}`">
                <th scope="row">{{index+1}}</th>
                <td>{{role.name}}</td>
                <td>{{role.created_at | myDate}}</td>
                <td>
                    <div class="btn-group">
                        <button
                            class="btn btn-outline-warning" style="color: #ffc107; border-color: #ffc107"
                            data-target="#exampleModal"
                            data-toggle="modal"
                            @click="getRoleById(role)">Edit
                        </button>
                        <button
                            @click="deleteRole(role.id, index)"
                            class="btn btn-outline-danger">Delete
                        </button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <!--<div class="d-flex justify-content-center">-->
            <!--<pagination style="width: auto" class="text-center mb-3" :data="productTypes" @pagination-change-page="getResults"></pagination>-->
        <!--</div>-->
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-if="editMode" class="modal-title text-success">Edit
                            product type</h5>
                        <h5 v-else class="modal-title text-success">Add Role</h5>
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form @submit.prevent="editMode ? updateRole() : addRole()">
                        <div class="modal-body">

                            <div class="form-group">
                                <label>Name</label>
                                <input v-model="form.name" type="text" name="name"
                                       class="form-control"
                                       :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                            <label>Permission</label>
                            <div v-for="(permis, index_permission) in allPermissions" :key="index_permission" >
                                 <input type="checkbox" v-model="form.rolePermissions" :value="permis.id" >
                                 <label class="form-check-label">{{permis.name}}</label>
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
        name: "Role",
        data() {
            return {
                editMode: false,
                roles: [],
                allPermissions:[],
                productTypes: {},
                form: new Form({
                    id:'',
                    name:'',
                    permissions: [],
                    rolePermissions: []
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
            openRole(){
                this.editMode = false;
                this.form.reset();
            },
            addRole() {
                if (this.role < 0){
                    this.role = null;
                }
                this.form.post('/api/addRole', this.form)
                .then(function (response) {
                    console.log(response);
                    Toast.fire({
                        icon: 'success',
                        title: response.data.message
                    });
                    $('#exampleModal').modal('hide');
                    Fire.$emit('loadRole');
                })
                .catch(function (error) {
                    console.log(error);
                })
            },
            getResults(page = 1){
                var num = this.itemPerPage;
                var url;
                if (this.$store.state.search == null){
                    url = '/api/getAllProductTypePaging/'+num+'?page=' + page;
                }else {
                    url = '/api/search/'+num+'?page=' + page + "&q="+this.$store.state.search;
                }
                axios.get(url)
                .then(response => {
                    console.log(response.data);
                    this.productTypes = response.data;
                })
            },
            getAllRole() {
                axios.get('/api/getAllRole')
                .then(response => {
                    console.log(response.data.roles);
                    this.roles = response.data.roles;
                   
                })
            },
            getAllPermissions() {
                axios.get('/api/getAllPermissions')
                .then(response => {
                    console.log(response.data.permission);
                    this.allPermissions = response.data.permission;
                })
            },
            deleteRole(id, index) {
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
                        );
                        var app = this;
                        axios.delete('/api/deleteRole/' + id)
                        .then(function (resp) {
                            app.roles.splice(index, 1);
                            console.log(resp)
                        })
                        .catch(function (resp) {
                            //alert("Could not delete company");
                            console.log(resp)
                        });
                    }

                })
            },
            getRoleById(role) {
                this.editMode = true;
                this.form.clear();
                $('#exampleModal').modal('show');
                this.form.fill(role);
            },
            updateRole() {
               const config = {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    }
                };
                this.form.post('/api/editRole/'+this.form.id,config)
                .then(function (response) {
                    console.log(response);
                    Toast.fire({
                        icon: 'success',
                        title: 'update successfully'
                    });
                    $('#exampleModal').modal('hide');
                    Fire.$emit('loadRole');
                })
                .catch(function (error) {
                    console.log(error);
                })
            }
        },
        created() {
            this.getAllRole();
            this.getAllPermissions();
            //this.getAllProductType(this.itemPerPage);
            Fire.$on('loadRole', ()=>{
                 this.getAllRole();
            });
            // setInterval(()=>this.getAllCategory(), 5000);
        }
    }
</script>

<style scoped>

</style>
