<template>
    <div>
        <router-link to="/admin/add-product">
            <button class="btn btn-outline-success float-right" data-toggle="modal"
                    data-target="#exampleModal">Add product
            </button>
        </router-link>

        <h2 class="text-center mb-3">All product</h2>
        <div class="d-flex justify-content-end">
            <p style="padding: 10px">Hiển thị số sản phẩm</p>
            <select style="width: 10%" class="form-control" id="exampleFormControlSelect1" v-model="itemPerPage" @change="getAllProduct(itemPerPage)"
                    :class="{ 'is-invalid': form.errors.has('idCategory') }">
                <option v-for="(item, index) in numPerPageList" :key="index" :value="item">{{item}}</option>
            </select>
        </div>

        <sorted-table :values="products.data" class="table table-bordered table-hover">
            <thead>
            <tr>
                <th scope="col" style="text-align: left; width: 10rem;">
                    <sort-link name="id">ID</sort-link>
                </th>
                <th scope="col" style="text-align: left; width: 10rem;">
                    <sort-link name="name">Name</sort-link>
                </th>
                <th scope="col" style="text-align: left; width: 10rem;">
                    <sort-link name="quantity">Quantity</sort-link>
                </th>
                <th scope="col" style="text-align: left; width: 10rem;">
                    <sort-link name="image">Image</sort-link>
                </th>
                <th scope="col" style="text-align: left; width: 10rem;">
                    <sort-link name="promotion">Promotion</sort-link>
                </th>
                <th scope="col" style="text-align: left; width: 10rem;">
                    <sort-link name="slug">Slug</sort-link>
                </th>
                <th scope="col" style="text-align: left; width: 10rem;">
                    <sort-link name="categoryName">Category</sort-link>
                </th>
                <th scope="col" style="text-align: left; width: 10rem;">
                    <sort-link name="productTypeName">ProductType</sort-link>
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
                    <td>{{ value.quantity }}</td>
                    <td v-if="value.product_img.length > 0">
                        <img :src="value.product_img[0].url" style="width: 50px; height: 50px">
                    </td>
                    <td v-else>
                        <img src="../../../../public/assets/customer/fashi/img/no-image.jpg" alt=""
                             style="width: 50px; height: 50px">
                    </td>
                    <td>{{ value.promotion }}</td>
                    <td>{{ value.slug }}</td>
                    <td>{{ value.categoryName }}</td>
                    <td>{{ value.productTypeName }}</td>
                    <td>{{ value.created_at | myDate }}</td>
                    <td>
                        <div class="btn-group">
                            <router-link
                                :to="{name: 'edit-product', params:{id: value.id}}"
                                class="btn btn-outline-warning">Edit
                            </router-link>
                            <button
                                @click="deleteProduct(value.id, index)"
                                class="btn btn-outline-danger">Delete
                            </button>
                        </div>
                    </td>
                </tr>
                </tbody>
            </template>
        </sorted-table>
        <div class="d-flex justify-content-center">
            <pagination style="width: auto" class="text-center mb-3" :data="products" @pagination-change-page="getResults"></pagination>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Product",
        data() {
            return {
                editMode: false,
                categories: [],
                productType: null,
                category: null,
                products: {},
                form: new Form({
                    id: '',
                    idCategory: -1,
                    name: '',
                    status: 1,
                    created_at: '',
                    idProductType: -1,
                    description: '',
                    quantity: '',
                    price: '',
                    image: '',
                    promotion: '',
                }),
                categoryId: '',
                itemPerPage: 2,
                numPerPageList: [
                    2,
                    3,
                    5
                ]
            }
        },
        methods: {
            getAllProduct(itemPerPage) {
                if (this.$store.state.search != null){
                    this.search();
                }else {
                    axios.get('/api/getAllProductPaging/'+ itemPerPage)
                    .then(response => {
                        console.log(response.data);
                        this.products = response.data;
                    })
                }

            },
            search(){
                console.log(this.$store.state.search);
                axios.get('/api/searchProduct/'+this.itemPerPage+'?q='+this.$store.state.search)
                .then(response => {
                    console.log(response.data);
                    this.products = response.data;
                })
            },
            deleteProduct(id, index) {
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
                        //var app = this;
                        axios.delete('/api/admin/product/' + id)
                        .then(function (resp) {
                            // app.products.splice(index, 1);
                            Fire.$emit('saveProduct');
                            console.log(resp)
                        })
                        .catch(function (resp) {
                            alert("Could not delete company");
                            console.log(resp)
                        });
                    }

                })
            },
            getResults(page = 1){
                var num = this.itemPerPage;
                var url;
                if (this.$store.state.search == null){
                    url = '/api/getAllProductPaging/'+num+'?page=' + page;
                }else {
                    url = '/api/searchProduct/'+num+ "?q="+this.$store.state.search+'&page=' + page;
                }
                axios.get(url)
                .then(response => {
                    console.log(response.data);
                    this.products = response.data;
                })
            },
            getProductById(producttype) {
                this.editMode = true;
                this.form.clear();
                $('#exampleModal').modal('show');
                this.form.fill(producttype);
            },
            updateProduct() {
                this.form.put('/api/admin/producttype/'+this.form.id)
                .then(function (response) {
                    console.log(response);
                    Toast.fire({
                        icon: 'success',
                        title: 'update successfully'
                    });
                    $('#exampleModal').modal('hide');
                    Fire.$emit('saveProduct');
                })
                .catch(function (error) {
                    console.log(error);
                })
            }
        },
        created() {
            this.getAllProduct(this.itemPerPage);
            Fire.$on('saveProduct', ()=>{
                this.getAllProduct(this.itemPerPage);
            });
            // setInterval(()=>this.getAllProduct(this.itemPerPage), 5000);
            Fire.$on('search', ()=>{
                if (this.$store.state.search != null){
                    this.search();
                } else {
                    this.getAllProduct(this.itemPerPage);
                }
            });
        }
    }
</script>

<style scoped>

</style>
