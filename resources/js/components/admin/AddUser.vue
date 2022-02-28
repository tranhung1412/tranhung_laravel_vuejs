<template>
    <div>
        <h2 class="text-center mb-3">Add User</h2>
        <form @submit.prevent="addUser">
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
                    <has-error :form="form" field="name"></has-error>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input v-model="form.password" type="password" name="password"
                           class="form-control"
                           :class="{ 'is-invalid': form.errors.has('password') }">
                    <has-error :form="form" field="password"></has-error>
                </div>
                <div class="form-group">
                    <label>Comfim Password</label>
                    <input v-model="form.re_password" type="password" name="re_password"
                           class="form-control"
                           :class="{ 'is-invalid': form.errors.has('re_password') }">
                    <has-error :form="form" field="re_password"></has-error>
                </div>
                <div class="form-group">
                <div class="form-group">
                    <label>Role</label>
                    <select class="form-control" id="exampleFormControlSelect1" v-model="form.role"
                            :class="{ 'is-invalid': form.errors.has('role') }">
                        <option :value=-1 >----- Select a category -----</option>
                        <option v-for="(role, index) in roles" :key="index" :value="role.id">{{role.name}}</option>
                    </select>
                    <has-error :form="form" field="role"></has-error>
                </div>
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
</template>

<script>
    export default {
        name: "AddUser",
        data() {
            return {
                roles: [],
                form: new Form({
                    id: '',
                    name: '',
                    email: '',
                    password: '',
                    re_password: '',
                    role:-1,
                }),
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
                    console.log(response.data);
                    Toast.fire({
                        icon: 'success',
                        title: response.data.message
                    });
                    current.$router.push({path: '/admin/user'});
                })
                .catch(function (error) {
                    console.log(error);
                })
            },
            getAllRole() {
                axios.get('/api/getAllRole')
                .then(response => {
                    console.log(response.roles);
                    this.roles = response.data.roles;
                })
            },
            // getAllCategory() {
            //     axios.get('/api/admin/category')
            //     .then(response => {
            //         console.log(response.data);
            //         this.categories = response.data;
            //     })
            // },
        },
        created() {
            this.getAllRole();
            // this.getAllProductType();
            // setInterval(()=>this.getAllCategory(), 5000);
        }
    }
</script>

<style scoped>

</style>
