<template>
  <div>
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Ver Usuario</h1>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="content container-fluid">
      <div class="row">
        <div class="col-md-4">
          <!-- Profile Image -->
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <template v-if="!fillVerUsuario.cRutaArchivo">
                  <img class="profile-user-img img-fluid img-circle" src="/img/user8-128x128.jpg" alt="User profile picture">
                </template>
                <template v-else>
                  <img :src="fillVerUsuario.cRutaArchivo" :alt="cNombreCompleto" class="profile-user-img img-fluid img-circle">
                </template>
              </div>

              <h3 class="profile-username text-center">{{ cNombreCompleto }}</h3>

              <p class="text-muted text-center">Vendedor</p>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

          <!-- About Me Box -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Sobre mi:</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <strong><i class="fab fa-mailchimp"></i> Nombre Completo:</strong>

              <p class="text-muted" v-text="cNombreCompleto"></p>

              <hr>

              <strong><i class="fas fa-envelope-open-text"></i> Correo Electrónico:</strong>

              <p class="text-muted" v-text="this.fillVerUsuario.cCorreo"></p>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-8">
            <div class="card">
              <div class="card-header p-2 bg-primary">
                <ul class="nav nav-pills">
                  <li class="nav-item"><span class="active">Formulario Editar Usuario</span></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active" id="settings">
                    <form class="form-horizontal">
                      <div class="form-group row">
                        <label class="col-md-3 col-form-label">Primer Nombre</label>
                        <div class="col-md-9">
                          <input type="text" class="form-control" v-model="fillEditarUsuario.cPrimerNombre" @keyup.enter="setEditarUsuario()">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-md-3 col-form-label">Segundo Nombre</label>
                        <div class="col-md-9">
                          <input type="text" class="form-control" v-model="fillEditarUsuario.cSegundoNombre" @keyup.enter="setEditarUsuario()">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-md-3 col-form-label">Apellido</label>
                        <div class="col-md-9">
                          <input type="text" class="form-control" v-model="fillEditarUsuario.cApellido" @keyup.enter="setEditarUsuario()">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-md-3 col-form-label">Usuario</label>
                        <div class="col-md-9">
                          <input type="text" class="form-control" v-model="fillEditarUsuario.cUsuario" @keyup.enter="setEditarUsuario()">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-md-3 col-form-label">Correo Electrónico</label>
                        <div class="col-md-9">
                          <input type="email" class="form-control" v-model="fillEditarUsuario.cCorreo" @keyup.enter="setEditarUsuario()">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-md-3 col-form-label">Contraseña</label>
                        <div class="col-md-9">
                          <el-input placeholder="Ingrese una Contraseña" v-model="fillEditarUsuario.cContrasena" @keyup.enter="setEditarUsuario" show-password></el-input>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-md-3 col-form-label">Fotografia</label>
                        <div class="col-md-9">
                          <input type="file" @change="getFile">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-sm-12">
                          <button class="btn btn-info btnFull" @click.prevent="setEditarUsuario" v-loading.fullscreen.lock="fullscreenLoading">Editar</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
      </div>
    </div>

    <div class="modal fade" :class="{ show: modalShow }" :style=" modalShow ? mostrarModal : ocultarModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sistema Laravel y Vue</h5>
                    <button class="close" @click="abrirModal"></button>
                </div>
                <div class="modal-body">
                  <div class="callout callout-danger" style="padding: 5px" v-for="(item, index) in mensajeError" :key="index" v-text="item"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" @click="abrirModal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
  </div>
</template>

<script>
export default {
  data(){
      return {
        fillEditarUsuario: {
          nIdUsuario: this.$attrs.id,
          cPrimerNombre: '',
          cSegundoNombre: '',
          cApellido: '',
          cUsuario: '',
          cCorreo: '',
          cContrasena: '',
          oFotografia: ''
        },
        fillVerUsuario: {
          nIdUsuario: this.$attrs.id,
          cPrimerNombre: '',
          cSegundoNombre: '',
          cApellido: '',
          cUsuario: '',
          cCorreo: '',
          cContrasena: '',
          oFotografia: '',
          cRutaArchivo: '',
        },
        form: new FormData,
        fullscreenLoading: false,
        modalShow: false,
        mostrarModal: {
            display: 'block',
            background: '#0000006b'
        },
        ocultarModal: {
            display: 'none'
        },
        error: 0,
        mensajeError: [],
      }
    },
    mounted() {   
      this.getUsuarioById();
    },
    computed: {
      cNombreCompleto(){
        return this.fillVerUsuario.cPrimerNombre + ' ' + this.fillVerUsuario.cSegundoNombre + ' ' + this.fillVerUsuario.cApellido;
      }
    },
    methods:{
      getUsuarioById(){
        this.fullscreenLoading = true;

        var url = '/administracion/usuario/getListarUsuarios'
        axios.get(url, {
          params: {
            'nIdUsuario': this.fillEditarUsuario.nIdUsuario,
          }
        }).then(response => {
          console.log(response.data);
          
          this.getUsuarioEditar(response.data[0]);
          this.getUsuarioVer(response.data[0]);

          this.fullscreenLoading = false;
        })
      },
      getUsuarioEditar(data){
        this.fillEditarUsuario.cPrimerNombre = data.firstname;
        this.fillEditarUsuario.cSegundoNombre = data.secondname;
        this.fillEditarUsuario.cApellido = data.lastname;
        this.fillEditarUsuario.cUsuario = data.username;
        this.fillEditarUsuario.cCorreo = data.email;
      },
      getUsuarioVer(data){
        this.fillVerUsuario.cPrimerNombre = data.firstname;
        this.fillVerUsuario.cSegundoNombre = data.secondname;
        this.fillVerUsuario.cApellido = data.lastname;
        this.fillVerUsuario.cUsuario = data.username;
        this.fillVerUsuario.cCorreo = data.email;
        this.fillVerUsuario.cRutaArchivo = data.profile_image;
      },
      abrirModal(){
        this.modalShow = !this.modalShow;
      },
      getFile(e){
        this.fillEditarUsuario.oFotografia = e.target.files[0];
      },
      setEditarUsuario(){
        if(this.validarRegistrarUsuario()){
          this.modalShow = true;
          return;
        }

        this.fullscreenLoading = true;

        if(!this.fillEditarUsuario.oFotografia || this.fillEditarUsuario.oFotografia == undefined){
          this.setGuardarUsuario(0);
        }else{
          this.setRegistrarArchivo();
        }
      },
      setRegistrarArchivo(){
        this.form.append('file', this.fillEditarUsuario.oFotografia)
        const config = { headers: { 'Content-Type': 'multipart/form-data' }}
        var url = '/archivo/setRegistrarArchivo'
        axios.post(url, this.form, config).then(response => {
          console.log(response);
          var nIdFile = response.data[0].nIdFile;
          this.setGuardarUsuario(nIdFile);
        })
      },
      setGuardarUsuario(nIdFile){
        var url = '/administracion/usuario/setEditarUsuario'
        axios.post(url, {
          'nIdUsuario': this.fillEditarUsuario.nIdUsuario,
          'cPrimerNombre': this.fillEditarUsuario.cPrimerNombre,
          'cSegundoNombre': this.fillEditarUsuario.cSegundoNombre,
          'cApellido': this.fillEditarUsuario.cApellido,
          'cUsuario': this.fillEditarUsuario.cUsuario,
          'cCorreo': this.fillEditarUsuario.cCorreo,
          'cContrasena': this.fillEditarUsuario.cContrasena,
          'oFotografia': nIdFile
        }).then(response => {
          this.fullscreenLoading = false;
          this.getUsuarioById();
          Swal.fire({
            icon: 'success',
            title: 'Se actualizó el usuario correctamente',
            showConfirmButton: false,
            timer: 1500
          })
        })
      },
      validarRegistrarUsuario(){
        this.error = 0;
        this.mensajeError = [];

        if(!this.fillEditarUsuario.cPrimerNombre){
          this.mensajeError.push("El Primer Nombre es un campo obligatorio")
        }
        if(!this.fillEditarUsuario.cApellido){
          this.mensajeError.push("El Apellido es un campo obligatorio")
        }
        if(!this.fillEditarUsuario.cUsuario){
          this.mensajeError.push("El Usuario es un campo obligatorio")
        }
        if(!this.fillEditarUsuario.cCorreo){
          this.mensajeError.push("El Correo Electrónico es un campo obligatorio")
        }

        if(this.mensajeError.length){
          this.error = 1;
        }

        return this.error;
      }
    }
}
</script>

<style>

</style>