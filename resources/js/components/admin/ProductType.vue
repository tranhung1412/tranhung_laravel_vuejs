<template>
    <div>
        <button class="btn btn-outline-success float-right" data-toggle="modal"
                data-target="#exampleModal" @click="openProductType()">Add product type
        </button>
        <h2 class="text-center mb-3">All product type</h2>
        <div class="d-flex justify-content-end">
            <p style="padding: 10px">Hiển thị số sản phẩm</p>
            <select style="width: 10%" class="form-control" v-model="itemPerPage" @change="getAllProductType(itemPerPage)"
                    :class="{ 'is-invalid': form.errors.has('idCategory') }">
                <option v-for="(item, index) in numPerPageList" :key="index" :value="item">{{item}}</option>
            </select>
        </div>
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Slug</th>
                <th scope="col">Created At</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>

            <tr v-for="(productType, index) in productTypes.data" :key="`${index}-${productType.id}`">
                <th scope="row">{{index+1}}</th>
                <td>{{productType.name}}</td>
                <td>{{productType.slug}}</td>
                <td>{{productType.created_at | myDate}}</td>
                <td>
                    <div class="btn-group">
                        <button
                            class="btn btn-outline-warning" style="color: #ffc107; border-color: #ffc107"
                            data-target="#exampleModal"
                            data-toggle="modal"
                            @click="getProductTypeById(productType)">Edit
                        </button>
                        <button
                            @click="deleteProductType(productType.id, index)"
                            class="btn btn-outline-danger">Delete
                        </button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            <pagination style="width: auto" class="text-center mb-3" :data="productTypes" @pagination-change-page="getResults"></pagination>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-if="editMode" class="modal-title text-success">Edit
                            product type</h5>
                        <h5 v-else class="modal-title text-success">Add
                            product type</h5>
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form @submit.prevent="editMode ? updateProductType() : addProductType()">
                        <div class="modal-body">

                            <div class="form-group">
                                <label>ProductType name</label>
                                <input v-model="form.name" type="text" name="name"
                                       class="form-control"
                                       :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Product type slug</label>
                                <input v-model="form.slug" type="text" name="name"
                                       class="form-control"
                                       :class="{ 'is-invalid': form.errors.has('slug') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Product category</label>
                                <select class="form-control" id="exampleFormControlSelect1" v-model="form.idCategory"
                                        :class="{ 'is-invalid': form.errors.has('idCategory') }">
                                    <option :value=-1>----- Select a category -----</option>
                                    <option v-for="(category, index) in categories" :key="index" :value="category.id">{{category.name}}</option>
                                </select>
                                <has-error :form="form" field="idCategory"></has-error>
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
        name: "ProductType",
        data() {
            return {
                editMode: false,
                categories: [],
                productTypes: {},
                form: new Form({
                    id: '',
                    idCategory: -1,
                    name: '',
                    status: 1,
                    slug: '',
                    created_at: ''
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
            openProductType(){
                this.editMode = false;
                this.form.reset();
            },
            addProductType() {
                if (this.idCategory < 0){
                    this.idCategory = null;
                }
                this.form.post('/api/admin/producttype', this.form)
                .then(function (response) {
                    console.log(response);
                    Toast.fire({
                        icon: 'success',
                        title: response.data.message
                    });
                    $('#exampleModal').modal('hide');
                    Fire.$emit('loadProductType');
                })
                .catch(function (error) {
                    console.log(error);
                })
            },
            // getAllProductType() {
            //     axios.get('/api/admin/producttype')
            //     .then(response => {
            //         console.log(response.data);
            //         this.productTypes = response.data;
            //     })
            // },
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
            getAllProductType(itemPerPage) {
                if (this.inputSearch != null){
                    this.search();
                } else {
                    axios.get('/api/getAllProductTypePaging/'+ itemPerPage)
                    .then(response => {
                        console.log(response.data);
                        this.productTypes = response.data;
                    })
                }

            },
            getAllCategory() {
                axios.get('/api/admin/category')
                .then(response => {
                    console.log(response.data);
                    this.categories = response.data;
                })
            },
            deleteProductType(id, index) {
                Swal.fire({
                    title: 'Bạn có muốn xoá?',
                    text: "Bạn không thể khôi phục lại dữ liệu này",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Đồng ý xoá'
                }).then((result) => {
                    if (result.value) {
                        var app = this;
                        axios.delete('/api/admin/producttype/' + id)
                        .then(function (response) {
                            if(response.data.status == 1){
                                // app.productTypes.splice(index, 1);
                                console.log(response);
                                Swal.fire(
                                    'Deleted!',
                                    'Xoá thành công.',
                                    'success'
                                );
                                Fire.$emit('loadProductType');
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
                            console.log(resp)
                        });
                    }

                })

            },
            getProductTypeById(producttype) {
                this.editMode = true;
                this.form.clear();
                $('#exampleModal').modal('show');
                this.form.fill(producttype);
            },
            updateProductType() {
                this.form.put('/api/admin/producttype/'+this.form.id)
                .then(function (response) {
                    console.log(response);
                    Toast.fire({
                        icon: 'success',
                        title: 'update successfully'
                    });
                    $('#exampleModal').modal('hide');
                    Fire.$emit('loadProductType');
                })
                .catch(function (error) {
                    console.log(error);
                })
            }
        },
        created() {
            this.getAllCategory();
            this.getAllProductType(this.itemPerPage);
            Fire.$on('loadProductType', ()=>{
                this.getAllProductType(this.itemPerPage);
            });
            // setInterval(()=>this.getAllCategory(), 5000);
        }
    }
</script>

<style scoped>

</style>
