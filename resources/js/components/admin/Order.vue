<template>
    <div>
        <!-- <button class="btn btn-outline-success float-right" data-toggle="modal"
                data-target="#exampleModal" @click="openAddOrder()">Add Order
        </button> -->
        <h2 class="text-center mb-3">All order</h2>
        <div class="d-flex justify-content-end">
            <p style="padding: 10px">Hiển thị số đơn đặt hàng</p>
            <select style="width: 10%" class="form-control" id="exampleFormControlSelect1"
                    v-model="itemPerPage" @change="getAllOrder(itemPerPage)"
                    :class="{ 'is-invalid': form.errors.has('idOrder') }">
                <option v-for="(item, index) in numPerPageList" :key="index" :value="item">
                    {{item}}
                </option>
            </select>
        </div>

        <sorted-table :values="orders.data" class="table table-bordered table-hover">
            <thead>
            <tr>
                <th scope="col" style="text-align: left; width: 10rem;">
                    <sort-link name="id">ID</sort-link>
                </th>
                <th scope="col" style="text-align: left; width: 10rem;">
                    <sort-link name="id">Code_Order</sort-link>
                </th>
                <th scope="col" style="text-align: left; width: 10rem;">
                    <sort-link name="name">Customer Name</sort-link>
                </th>
                <th scope="col" style="text-align: left; width: 10rem;">
                    <sort-link name="slug">Phone</sort-link>
                </th>
                <th scope="col" style="text-align: left; width: 10rem;">
                    <sort-link name="slug">Total Price</sort-link>
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
                    <td disabled="true">{{ value.id }}</td>
                    <td>{{ value.code_order }}</td>
                    <td>{{ value.name }}</td>
                    <td>{{ value.phone }}</td>
                    <td>{{ value.total_price }}</td>
                    <td>{{ value.created_at }}</td>
                    <td>
                        <div class="btn-group">
                            <button
                                class="btn btn-outline-warning"
                                data-target="#exampleModal"
                                data-toggle="modal"
                                @click="getOrderById(value)">Show detail
                            </button>
                            <button
                                class="btn btn-outline-success"
                                @click="getOrderById(value)">Send to ship
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
            <pagination style="width: auto" class="text-center mb-3" :data="orders"
                        @pagination-change-page="getResults"></pagination>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-if="editMode" class="modal-title text-success">Show
                            detail</h5>
                        <h5 v-else class="modal-title text-success">Add
                            Order</h5>
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editMode ? updateOrder() : addOrder()">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Order name</label>
                                <input v-model="form.code_order" type="text" name="name"
                                       class="form-control"
                                       :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Order name</label>
                                <input v-model="form.name" type="text" name="name"
                                       class="form-control"
                                       :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Order phone</label>
                                <input v-model="form.phone" type="text" name="slug"
                                       class="form-control"
                                       :class="{ 'is-invalid': form.errors.has('slug') }">
                                <has-error :form="form" field="slug"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Order address</label>
                                <input v-model="form.address" type="text" name="slug"
                                       class="form-control"
                                       :class="{ 'is-invalid': form.errors.has('slug') }">
                                <has-error :form="form" field="slug"></has-error>
                            </div>
                            <h3>List Order</h3>
                            <div class="row">
                                <div class="form-group col-sm"
                                     v-for="(item, index) in form.orderDetail" :key="index">
                                    <label>Id Product</label>
                                    <input v-model="item.idProduct" type="text" name="slug"
                                           class="form-control"
                                           :class="{ 'is-invalid': form.errors.has('slug') }">
                                    <has-error :form="form" field="slug"></has-error>

                                    <label>Quantity</label>
                                    <input v-model="item.quantity" type="text" name="slug"
                                           class="form-control"
                                           :class="{ 'is-invalid': form.errors.has('slug') }">
                                    <has-error :form="form" field="slug"></has-error>

                                    <img :src="item.image" alt=""
                                         style="height: 100px; width: 100px">
                                    <br>

                                    <label>Price</label>
                                    <input v-model="item.price" type="text" name="slug"
                                           class="form-control"
                                           :class="{ 'is-invalid': form.errors.has('slug') }">
                                    <has-error :form="form" field="slug"></has-error>
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
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Order",
        data() {
            return {
                editMode: false,
                orders: {},
                itemPerPage: 10,
                numPerPageList: [
                    2,
                    3,
                    10
                ],
                form: new Form({
                    id: '',
                    name: '',
                    status: 1,
                    code_order: '',
                    address: '',
                    phone: '',
                    orderDetail: [],
                    created_at: ''
                }),
                error: null,
            }
        },
        methods: {
            openAddOrder() {
                this.editMode = false;
                this.form.reset();
            },

            getResults(page = 1) {
                var num = this.itemPerPage;
                var url;
                if (this.$store.state.search == null) {
                    url = '/api/getAllOrderPaging/' + num + '?page=' + page;
                } else {
                    url = '/api/searchOrder/' + num + "?q=" + this.$store.state.search + '&page='
                        + page;
                }
                axios.get(url)
                .then(response => {
                    console.log(response.data);
                    this.orders = response.data;
                })
            },
            getAllOrder(itemPerPage) {
                if (this.$store.state.search != null) {
                    this.search();
                } else {
                    axios.get('/api/getAllOrderPaging/' + itemPerPage)
                    .then(response => {
                        console.log(response.data);
                        this.orders = response.data;
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
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        );
                        var app = this;
                        axios.delete('/api/admin/Order/' + id)
                        .then(function (resp) {
                            app.orders.data.splice(index, 1);
                            console.log(resp)
                        })
                        .catch(function (resp) {
                            alert("Could not delete company");
                            console.log(resp)
                        });
                    }

                })

            },
            getOrderById(Order) {
                this.editMode = true;
                this.form.clear();
                $('#exampleModal').modal('show');
                this.form.fill(Order);
            },
            updateOrder() {
                this.form.put('/api/admin/Order/' + this.form.id)
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
            search() {
                console.log(this.$store.state.search);
                axios.get('/api/searchOrder/' + this.itemPerPage + '?q=' + this.$store.state.search)
                .then(response => {
                    console.log(response.data);
                    this.orders = response.data;
                })
            }
        },
        created() {
            this.getAllOrder(this.itemPerPage);
            Fire.$on('afterSaveChange', () => {
                this.getAllOrder(this.itemPerPage);
            });
            Fire.$on('search', () => {
                if (this.$store.state.search != null) {
                    this.search();
                } else {
                    this.getAllOrder(this.itemPerPage);
                }
            });

            // setInterval(()=>this.getAllOrder(), 5000);
        }
    }
</script>

<style scoped>

</style>
