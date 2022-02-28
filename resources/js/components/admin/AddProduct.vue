<template>
    <div>
        <h2 class="text-center mb-3">Add product</h2>
        <form @submit.prevent="addProduct">
            <div class="modal-body">
                <div class="form-group">
                    <label>Category name</label>
                    <input v-model="form.name" type="text" name="name"
                           class="form-control"
                           :class="{ 'is-invalid': form.errors.has('name') }">
                    <has-error :form="form" field="name"></has-error>
                </div>
                <div class="form-group">
                    <label>Product description</label>
                    <ckeditor :config="editorConfig" v-model="form.description"></ckeditor>

                </div>
                <div class="form-group">
                    <label>Product type slug</label>
                    <input v-model="form.slug" type="text" name="name"
                           class="form-control"
                           :class="{ 'is-invalid': form.errors.has('slug') }">
                    <has-error :form="form" field="name"></has-error>
                </div>
                <div class="form-group">
                    <label>Product price</label>
                    <input type="number" name="" v-model="form.price"
                           placeholder="Enter price"
                           :class="{ 'is-invalid': form.errors.has('price') }"
                           class="form-control">
                    <has-error :form="form" field="name"></has-error>
                </div>
                <div class="form-group">
                    <label>Product promotion</label>
                    <input type="number" name="category_name" v-model="form.promotion"
                           placeholder="Enter promotion"
                           class="form-control">
                </div>
                <div class="form-group">
                    <label>Product Quantity</label>
                    <input type="number" name="category_name" v-model="form.quantity"
                           placeholder="Enter quantity"
                           class="form-control">
                </div>
                <h3>Thông số kĩ thuật</h3>
                <div class="form-group">
                    <label>Màn hình</label>
                    <input type="text" name="category_name" v-model="form.screen"
                           placeholder=""
                           class="form-control">
                </div>
                <div class="form-group">
                    <label>Hệ Điều Hành</label>
                    <input type="text" name="category_name" v-model="form.operating_system"
                           placeholder=""
                           class="form-control">
                </div>
                <div class="form-group">
                    <label>Card Đồ Họa</label>
                    <input type="text" name="category_name" v-model="form.rear_camera"
                           placeholder=""
                           class="form-control">
                </div>
                <div class="form-group">
                    <label>Camera</label>
                    <input type="text" name="category_name" v-model="form.front_camera"
                           placeholder=""
                           class="form-control">
                </div>
                <div class="form-group">
                    <label>CPU</label>
                    <input type="text" name="category_name" v-model="form.cpu"
                           placeholder=""
                           class="form-control">
                </div>
                <div class="form-group">
                    <label>RAM</label>
                    <input type="text" name="category_name" v-model="form.ram"
                           placeholder=""
                           class="form-control">
                </div>
                <div class="form-group">
                    <label>Ổ cứng</label>
                    <input type="text" name="category_name" v-model="form.internal_memory"
                           placeholder=""
                           class="form-control">
                </div>
                <div class="form-group">
                    <label>Cổng kết nối</label>
                    <input type="text" name="category_name" v-model="form.sim"
                           placeholder=""
                           class="form-control">
                </div>
                <div class="form-group">
                    <label>Pin</label>
                    <input type="text" name="category_name" v-model="form.battery"
                           placeholder=""
                           class="form-control">
                </div>
                <div class="form-group">
                    <label>Thiết Kế</label>
                    <input type="text" name="category_name" v-model="form.design"
                           placeholder=""
                           class="form-control">
                </div>

                <div class="form-group">
                    <label>Hình Ảnh</label>
                        <div>
                            <input type="file" @change="getImage" ref="file" name="file[]" multiple >
                            <button class="btn btn-success" @click.prevent="clearImage">Clear</button>
                        </div>
                        <span  v-for="(img, index) in listImage" :key="index">
                            <img :src="img" alt="" style="height: 80px; height: 80px;margin-top:30px">
                        </span>
                </div>
                

                <div class="form-group">
                    <label>Product category</label>
                    <select class="form-control" id="exampleFormControlSelect1" v-model="form.idCategory"
                            :class="{ 'is-invalid': form.errors.has('idCategory') }" @change.prevent="getAllProductType(form.idCategory)">
                        <option :value=-1>----- Select a category -----</option>
                        <option v-for="(category, index) in categories" :key="index" :value="category.id">{{category.name}}</option>
                    </select>
                    <has-error :form="form" field="idCategory"></has-error>
                </div>
                <div class="form-group" v-if="this.productTypes.length > 0">
                    <label>Product category</label>
                    <select class="form-control"  v-model="form.idProductType"
                            :class="{ 'is-invalid': form.errors.has('idCategory') }">
                        <option :value=-1>----- Select a product type -----</option>
                        <option v-for="(productType, index) in productTypes" :key="index" :value="productType.id">{{productType.name}}</option>
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
                <router-link :to="{name:'admin-product'}" type="submit" class="btn btn-secondary"
                        data-dismiss="modal" >Close
                </router-link>
                <button type="submit" class="btn btn-primary">Save
                    changes
                </button>
            </div>
        </form>
       <LoadingAnition :isLoadingAnimation="isLoading"></LoadingAnition>
    </div>
</template>

<script>
    import LoadingAnition from "../customer/LoadingAnimation";
    export default {
        name: "AddProduct",
        components: {
            LoadingAnition
        },
        data() {
            return {
                isLoading: false,
                listImage: [],
                avatar: '',
                filename: null,
                file:[],
                success: '',
                data:'',
                editMode: false,
                categories: [],
                productTypes: [],
                products: null,
                form: new Form({
                    id: '',
                    idCategory: -1,
                    name: '',
                    slug: '',
                    status: 1,
                    created_at: '',
                    idProductType: -1,
                    description: '',
                    quantity: '',
                    price: '',
                    promotion: '',
                    screen:'',
                    operating_system: '',
                    rear_camera: '',
                    front_camera: '',
                    cpu: '',
                    ram: '',
                    internal_memory: '',
                    sim: '',
                    battery: '',
                    design: '',

                }),
                categoryId: '',
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
            openProduct(){
                this.editMode = false;
                this.form.reset();
            },
            getImage(e){
                let image = this.$refs.file.files;
                var current = this;
               
                for(let i=0;i<image.length;i++){
                    let reader = new FileReader();
                    reader.readAsDataURL(image[i]);
                    reader.onload = e => {
                        current.avatar = e.target.result;
                         current.listImage.push(current.avatar);
                    };
                      console.log(this.avatar);
                     
                }
              
            },
             clearImage(){
                this.avatar = "";
                console.log("aaaaa");
                this.listImage = [];
                this.$refs.file.type='text';
                this.$refs.file.type='file';
            },
            addProduct() {
                const config = {
                    headers: {
                        'content-type': 'multipart/form-data',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    }
                };
                var current = this;
                let formData = new FormData();
                let image =this.$refs.file.files;
                this.file = image;
                for(let i=0;i<image.length;i++){
                    formData.append('file[]',image[i]);
                }
                formData.append('name',current.form.name);
                formData.append('description',current.form.description);
                formData.append('quantity',current.form.quantity);
                formData.append('price',current.form.price);
                formData.append('slug',current.form.slug);
                formData.append('promotion',current.form.promotion);
                formData.append('idCategory',current.form.idCategory);
                formData.append('idProductType',current.form.idProductType);
                formData.append('screen',current.form.screen);
                formData.append('operating_system',current.form.operating_system);
                formData.append('rear_camera',current.form.rear_camera);
                formData.append('front_camera',current.form.front_camera);
                formData.append('cpu',current.form.cpu);
                formData.append('ram',current.form.ram);
                formData.append('internal_memory',current.form.internal_memory);
                formData.append('sim',current.form.sim);
                formData.append('battery',current.form.battery);
                formData.append('design',current.form.design);
                formData.append('status',current.form.status);
                current.isLoading = true;
                axios.post('/api/admin/product',formData, config)
                .then(function (response) {
                    console.log(response.data.message);
                    current.isLoading = false;
                    current.$router.push({path: '/admin/product'});
                    Toast.fire({
                        icon: 'success',
                        title: "Them thanh cong"
                    });
                })
                .catch(function (error) {
                    this.isLoading = false;
                    console.log(error);
                });
            },
            getAllProductType(id) {
                this.form.idProductType = -1;
                axios.get('/api/getProductTypeByCategoryId/'+ id)
                .then(response => {
                    console.log(response.data);
                    this.productTypes = response.data.product_type;
                })
            },
            getAllCategory() {
                axios.get('/api/admin/category')
                .then(response => {
                    console.log(response.data);
                    this.categories = response.data;
                })
            }
        },
        created() {
            this.getAllCategory();
            this.getAllProductType();
            // setInterval(()=>this.getAllCategory(), 5000);
        }
    }
</script>

<style scoped>

</style>
