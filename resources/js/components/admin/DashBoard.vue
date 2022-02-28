<template>
    <div class="row">
        <div class="form-group col-sm">
            <h4>Sản phẩm bán chạy nhất</h4>
            <column-chart :data="chartOrder" :max="50"></column-chart>
        </div>
        <div class="form-group col-sm">
            <h4>Tổng doanh thu tháng</h4>
            <column-chart :data="chartShip" :max="50"></column-chart>
        </div>
    </div>
</template>

<script>
    
</script>

<style scoped>

</style>
