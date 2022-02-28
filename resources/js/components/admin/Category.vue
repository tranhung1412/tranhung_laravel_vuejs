<template>
    <div>
        <button class="btn btn-outline-success float-right" data-toggle="modal"
                data-target="#exampleModal" @click="openAddCategory()">Add category
        </button>
        <h2 class="text-center mb-3">All category</h2>
        <div class="d-flex justify-content-end">
            <p style="padding: 10px">Hiển thị số sản phẩm</p>
            <select style="width: 10%" class="form-control" id="exampleFormControlSelect1" v-model="itemPerPage" @change="getAllCategory(itemPerPage)"
                    :class="{ 'is-invalid': form.errors.has('idCategory') }">
                <option v-for="(item, index) in numPerPageList" :key="index" :value="item">{{item}}</option>
            </select>
        </div>
        <!--<table class="table table-bordered table-hover">-->
            <!--<thead>-->
            <!--<tr>-->
                <!--<th scope="col">Id</th>-->
                <!--<th scope="col">Name</th>-->
                <!--<th scope="col">Slug</th>-->
                <!--<th scope="col">Created At</th>-->
                <!--<th scope="col">Action</th>-->
            <!--</tr>-->
            <!--</thead>-->
            <!--<tbody>-->

            <!--<tr v-for="(category, index) in categories.data" :key="`${index}-${category.id}`">-->
                <!--<th scope="row">{{index+1}}</th>-->
                <!--<td>{{category.name}}</td>-->
                <!--<td>{{category.slug}}</td>-->
                <!--<td>{{category.created_at | myDate}}</td>-->
                <!--<td>-->
                    <!--<div class="btn-group">-->
                        <!--<button-->
                            <!--class="btn btn-outline-warning" style="color: #ffc107; border-color: #ffc107"-->
                            <!--data-target="#exampleModal"-->
                            <!--data-toggle="modal"-->
                            <!--@click="getCategoryById(category)">Edit-->
                        <!--</button>-->
                        <!--<button-->
                            <!--@click="deleteCategroy(category.id, index)"-->
                            <!--class="btn btn-outline-danger">Delete-->
                        <!--</button>-->
                    <!--</div>-->
                <!--</td>-->
            <!--</tr>-->
            <!--</tbody>-->
        <!--</table>-->
        <sorted-table :values="categories.data" class="table table-bordered table-hover">
            <thead>
            <tr>
                <th scope="col" style="text-align: left; width: 10rem;">
                    <sort-link name="id">ID</sort-link>
                </th>
                <th scope="col" style="text-align: left; width: 10rem;">
                    <sort-link name="name">Name</sort-link>
                </th>
                <th scope="col" style="text-align: left; width: 10rem;">
                    <sort-link name="slug">Slug</sort-link>
                </th>
                <th scope="col" style="text-align: left; width: 10rem;">
                    <sort-link name="created_at">Created at</sort-link>
                </th>
                <th scope="col" style="text-align: left; width: 10rem;">
                    Action
                </th>
            </tr>
            </thead>
            <template #body="sort">
                <tbody>
                <tr v-for="(value, index) in sort.values" :key="`${index}-${value.id}`">
                    <td>{{ value.id }}</td>
                    <td>{{ value.name }}</td>
                    <td>{{ value.slug }}</td>
                    <td>{{ value.created_at }}</td>
                    <td>
                        <div class="btn-group">
                            <button
                                class="btn btn-outline-warning"
                                data-target="#exampleModal"
                                data-toggle="modal"
                                @click="getCategoryById(value)">Edit
                            </button>
                            <button
                                @click="deleteCategroy(value.id, index)"
                                class="btn btn-outline-danger">Delete
                            </button>
                        </div>
                    </td>
                </tr>
                </tbody>
            </template>
        </sorted-table>
        <div class="d-flex justify-content-center">
            <pagination style="width: auto" class="text-center mb-3" :data="categories" @pagination-change-page="getResults"></pagination>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-if="editMode" class="modal-title text-success">Edit
                            category</h5>
                        <h5 v-else class="modal-title text-success">Add
                            category</h5>
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editMode ? updateCategory() : addCategory()">
                        <div class="modal-body">

                            <div class="form-group">
                                <label>Category name</label>
                                <input v-model="form.name" type="text" name="name"
                                       class="form-control"
                                       :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Category slug</label>
                                <input v-model="form.slug" type="text" name="slug"
                                       class="form-control"
                                       :class="{ 'is-invalid': form.errors.has('slug') }">
                                <has-error :form="form" field="slug"></has-error>
                            </div>
                            <fieldset class="form-group">
                                <div class="row">
                                    <legend class="col-form-label col-sm-2 pt-0">Status</legend>
                                    <div class="col-sm-10">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio"
                                                   name="publication_status"
                                                   id="publication_status" value="1"
                                                   v-model="form.status" checked>
                                            <label class="form-check-label"
                                                   for="publication_status">
                                                Published
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio"
                                                   name="publication_status"
                                                   id="unpublished" value="0"
                                                   v-model="form.status">
                                            <label class="form-check-label" for="unpublished">
                                                Unpublished
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>

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
        name: "Category",
        data() {
            return {
                editMode: false,
                categories: {},
                itemPerPage: 2,
                numPerPageList: [
                    2,
                    3,
                    5
                ],
                form: new Form({
                    id: '',
                    name: '',
                    status: 1,
                    slug: '',
                    created_at: ''
                }),
                error: null,
            }
        },
        methods: {
            openAddCategory(){
                this.editMode = false;
                this.form.reset();
            },
            addCategory() {
                this.form.post('/api/admin/category', this.form)
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
            getResults(page = 1){
                var num = this.itemPerPage;
                var url;
                if (this.$store.state.search == null){
                    url = '/api/getAllCategoryPaging/'+num+'?page=' + page;
                }else {
                    url = '/api/searchCategory/'+num+ "?q="+this.$store.state.search+'&page=' + page;
                }
                axios.get(url)
                .then(response => {
                    console.log(response.data);
                    this.categories = response.data;
                })
            },
            getAllCategory(itemPerPage) {
                if (this.$store.state.search != null){
                    this.search();
                }else {
                    axios.get('/api/getAllCategoryPaging/'+ itemPerPage)
                    .then(response => {
                        console.log(response.data);
                        this.categories = response.data;
                    })
                }


            },
            deleteCategroy(id, index) {
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

                        var app = this;
                        axios.delete('/api/admin/category/' + id)
                        .then(function (resp) {
                            if(resp.data.status == 1){
                                // app.productTypes.splice(index, 1);
                                console.log(resp);
                                Swal.fire(
                                    'Deleted!',
                                    'Xoá thành công.',
                                    'success'
                                );
                                Fire.$emit('afterSaveChange');
                            }else {
                                Swal.fire(
                                    'Lỗi!',
                                    'Xoá thất bại. Một trường khác đang sử dụng trường này vui lòng kiểm tra lại',
                                    'error'
                                );
                            }
                        })
                        .catch(function (resp) {
                            // alert("Could not delete company");
                            // console.log(resp)
                        });
                    }

                })

            },
            getCategoryById(category) {
                this.editMode = true;
                  this.form.clear();
                $('#exampleModal').modal('show');
                this.form.fill(category);
            },
            updateCategory() {
                this.form.put('/api/admin/category/'+this.form.id)
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
            search(){
                console.log(this.$store.state.search);
                axios.get('/api/searchCategory/'+this.itemPerPage+'?q='+this.$store.state.search)
                .then(response => {
                    console.log(response.data);
                    this.categories = response.data;
                })
            }
        },
        created() {
            this.getAllCategory(this.itemPerPage);
            Fire.$on('afterSaveChange', ()=>{
                this.getAllCategory(this.itemPerPage);
            });
            Fire.$on('search', ()=>{
                if (this.$store.state.search != null){
                    this.search();
                } else {
                    this.getAllCategory(this.itemPerPage);
                }
            });

            // setInterval(()=>this.getAllCategory(), 5000);
        }
    }
</script>

<style scoped>

</style>
