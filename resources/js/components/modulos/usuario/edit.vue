<template>
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Editar Usuario</h1>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->

    <div class="content container-fluid">
      <div class="card">
        <div class="card-header">
          <div class="card-tools">
            <router-link class="btn btn-info btn-sm" :to="'/usuario'">
              <i class="fas fa-arrow-left"></i> Regresar
            </router-link>
          </div>
        </div>
        <div class="card-body">
          <div class="container-fluid">
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Formulario Editar Usuario</h3>
              </div>
              <div class="card-body">
                <form role="form">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-md-3 col-form-label">Primer Nombre</label>
                        <div class="col-md-9">
                          <input type="text" class="form-control" v-model="fillEditarUsuario.cPrimerNombre" @keyup.enter="setEditarUsuario()">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-md-3 col-form-label">Segundo Nombre</label>
                        <div class="col-md-9">
                          <input type="text" class="form-control" v-model="fillEditarUsuario.cSegundoNombre" @keyup.enter="setEditarUsuario()">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-md-3 col-form-label">Apellido</label>
                        <div class="col-md-9">
                          <input type="text" class="form-control" v-model="fillEditarUsuario.cApellido" @keyup.enter="setEditarUsuario()">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-md-3 col-form-label">Usuario</label>
                        <div class="col-md-9">
                          <input type="text" class="form-control" v-model="fillEditarUsuario.cUsuario" @keyup.enter="setEditarUsuario()">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-md-3 col-form-label">Correo Electrónico</label>
                        <div class="col-md-9">
                          <input type="email" class="form-control" v-model="fillEditarUsuario.cCorreo" @keyup.enter="setEditarUsuario()">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-md-3 col-form-label">Contraseña</label>
                        <div class="col-md-9">
                          <el-input placeholder="Ingrese una Contraseña" v-model="fillEditarUsuario.cContrasena" @keyup.enter="setEditarUsuario" show-password></el-input>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-md-3 col-form-label">Fotografia</label>
                        <div class="col-md-9">
                          <input type="file" class="form-control" @change="getFile">
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>                
              <div class="card-footer">
                <div class="row">
                  <div class="col-md-4 offset-4">
                    <button class="btn btn-flat btn-info btnWidth" @click.prevent="setEditarUsuario" v-loading.fullscreen.lock="fullscreenLoading">Editar</button>
                    <button class="btn btn-flat btn-default btnWidth" @click.prevent="limpiarCampos">Limpiar</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
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
    methods: {
      getUsuarioById(){
        this.fullscreenLoading = true;

        var url = '/administracion/usuario/getUsuarioEditar'
        axios.get(url, {
          params: {
            'id': this.fillEditarUsuario.nIdUsuario,
          }
        }).then(response => {
          this.fillEditarUsuario.cPrimerNombre = response.data.firstname;
          this.fillEditarUsuario.cSegundoNombre = response.data.secondname;
          this.fillEditarUsuario.cApellido = response.data.lastname;
          this.fillEditarUsuario.cUsuario = response.data.username;
          this.fillEditarUsuario.cCorreo = response.data.email;
          this.fullscreenLoading = false;
        })
      },
      abrirModal(){
        this.modalShow = !this.modalShow;
      },
      limpiarCampos(){
        this.fillEditarUsuario.cPrimerNombre = '';
        this.fillEditarUsuario.cSegundoNombre = '';
        this.fillEditarUsuario.cApellido = '';
        this.fillEditarUsuario.cUsuario = '';
        this.fillEditarUsuario.cCorreo = '';
        this.fillEditarUsuario.cContrasena = '';
        this.fillEditarUsuario.oFotografia = '';
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
        axios.put(url, {
          'id': this.fillEditarUsuario.nIdUsuario,
          'firstname': this.fillEditarUsuario.cPrimerNombre,
          'secondname': this.fillEditarUsuario.cSegundoNombre,
          'lastname': this.fillEditarUsuario.cApellido,
          'username': this.fillEditarUsuario.cUsuario,
          'email': this.fillEditarUsuario.cCorreo,
          'password': this.fillEditarUsuario.cContrasena,
          'file_id': nIdFile
        }).then(response => {
          this.fullscreenLoading = false;
          
          Swal.fire({
            icon: 'success',
            title: 'Se actualizó el usuario correctamente',
            showConfirmButton: false,
            timer: 1500
          });

          this.$router.push('/usuario');
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