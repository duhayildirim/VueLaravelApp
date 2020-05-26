<template>
    <div class="container">
        <user-modal :item="item" v-on:onSaved="refreshData" ref="userModal"> </user-modal>
        <div class="btn-group float-right">
            <button class="btn btn-info" @click="fetchData"> Yenile </button>
            <button class="btn btn-success" @click="createData"> Yeni Kullanıcı </button>
        </div>
        <h1>Kullanıcılar</h1>
        <div class="alert alert-danger" v-if="errorMessage">
            {{errorMessage}}
        </div>
        <table class="table table-bordered table-hover" v-if="list && list.length">
            <tr>
                <th>ID</th>
                <th>AD</th>
                <th>E-Mail</th>
                <th>İşlem</th>
            </tr>
            <tr v-for="{id,name,email} in list">
                <td>{{id}}</td>
                <td>{{name}}</td>
                <td>{{email}}</td>
                <td>
                    <button class="btn btn-success" @click="editData(id)"> Düzenle </button>
<!--                    <button class="btn btn-danger" @click="deleteData(id)"> Sil </button>-->
                </td>
            </tr>
        </table>
        <p v-else> Kayıt Bulunamadı </p>
        <pagination :meta="meta" v-on:pageChange="fetchData"></pagination>
    </div>
</template>

<script>
    import Pagination from "../../components/Pagination.vue";
    import UserModal from "./UserModal.vue";

    export default {
        components : {
            Pagination , UserModal
        },
        data() {
            return {
                list: null,
                errorMessage: null,
                meta: {},
                item: {}
            }
        },
        created() {
            this.fetchData();
        },
        methods: {
            fetchData(page = 1) {
                this.errorMessage = null;
                this.list = null;
                window.axios.get("/users" , { params: { page }})
                .then(response => {
                   // debugger; // source json verinin içeriğini görmek için kullanıyorum
                   this.list = response.data.data;
                   this.meta = response.data.meta;
                })
                .catch(error => {
                   // debugger; // source da hataları görmek için kullanıyorum
                    if (error.response != null)
                        this.errorMessage = error.response.data.message;
                    else
                        this.errorMessage = error.message;
                })
            },
            createData() {
                this.item = {};
                this.$refs.userModal.errorMessage = '';
                $('#userModal').modal('show');
            },
            refreshData() {
                this.fetchData();
            },
            editData(id) {
                window.axios.get("/users/"+id)
                    .then(response => {
                        // debugger; // source json verinin içeriğini görmek için kullanıyorum
                        this.$refs.userModal.errorMessage = '';
                        this.item = response.data;
                        $('#userModal').modal('show');
                    })
                    .catch(error => {
                        // debugger; // source da hataları görmek için kullanıyorum
                        if (error.response != null)
                            this.errorMessage = error.response.data.message;
                        else
                            this.errorMessage = error.message;
                    });
            },
            deleteData(id){
                swal({
                    title: 'Emin misiniz?',
                    text: 'Bu işlem geri alınamaz',
                    type: 'warning',
                    showCancelButton: 'true',
                    cancelButtonText: 'Vazgeç',
                    confirmButtonText: 'Sil'
                }).then(result => {
                    if (result.value) {
                        axios.delete("/users/" + id)
                            .then(response => {
                                this.fetchData();
                            });
                    }
                })
            }
        }
    }
</script>
