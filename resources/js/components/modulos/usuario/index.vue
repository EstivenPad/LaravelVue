<template>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Usuarios</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid-->

      <div class="content container-fluid">
        <div class="card">
          <div class="card-header">
            <!-- <div class="card-tools"> -->
              <div class="row">
                <div class="col-md-2" style="padding: 0%">
                  <template>
                    <el-select v-model="filtro" placeholder="Filtro" clearable>
                      <el-option
                        v-for="item in opciones"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value">
                      </el-option>
                    </el-select>
                  </template>
                </div>                  
                <el-input 
                  class="col-md-3"
                  placeholder="Criterio"
                  v-model="criterio"
                  @keyup.enter="getListarUsuarios(filtro, criterio)"
                  clearable>
                </el-input>
                <div class="col-md-2">
                  <button class="btn btn-info" @click.prevent="getListarUsuarios(filtro, criterio)" v-loading.fullscreen.lock="fullscreenLoading">Buscar</button>
                </div>               
              </div>
          </div>
          <div class="card-body table-responsive">
            <div class="container-fluid">
              <template v-if="listarUsuariosPaginated.length">
                <table class="table table-hover table-head-fixed text-nowrap projects table-striped">
                  <thead> 
                    <tr>
                      <th>Fotografia</th>
                      <th>Nombre</th>
                      <th>Correo</th>
                      <th>Usuario</th>
                      <th>Estado</th>
                      <th>Acción</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(item, index) in listarUsuariosPaginated" :key="index">
                      <td>
                        <template v-if="!item.profile_image">
                          <li class="user-block">
                            <img src="/img/user8-128x128.jpg" :alt="item.username" class="profile-avatar-img img-fluid img-circle">
                          </li>
                        </template>
                        <template v-else>
                          <li class="user-block">
                            <img :src="item.profile_image" :alt="item.username" class="profile-avatar-img img-fluid img-circle">
                          </li>
                        </template>
                      </td>
                      <td v-text="item.firstname + ' ' + item.secondname + ' ' + item.lastname"></td>
                      <td v-text="item.email"></td>
                      <td v-text="item.username"></td>
                      <td>
                        <template v-if="item.state == 'A'">
                          <span class="badge badge-success" v-text="'ACTIVO'"></span>
                        </template>
                        <template v-else>
                          <span class="badge badge-danger" v-text="'INACTIVO'"></span>
                        </template>
                      </td>
                      <td>
                        <router-link class="btn btn-flat btn-primary btn-sm" :to="{name: 'usuario.ver', params: {id: item.id }}">
                          <i class="fas fa-folder"></i> Ver
                        </router-link>
                        <template v-if="item.state == 'A'">
                          <router-link class="btn btn-flat btn-info btn-sm" :to="{name:'usuario.editar', params: { id: item.id }}">
                            <i class="fas fa-pencil-alt"></i> Editar
                          </router-link>
                          <router-link class="btn btn-flat btn-secondary btn-sm" :to="'/'">
                            <i class="fas fa-key"></i> Permiso
                          </router-link>
                          <button class="btn btn-flat btn-danger btn-sm" @click.prevent="setCambiarEstadoUsuario(1, item.id, filtro, criterio)">
                            <i class="fas fa-trash"></i> Desactivar
                          </button>
                        </template> 
                        <template v-else>
                          <button class="btn btn-flat btn-success btn-sm" @click.prevent="setCambiarEstadoUsuario(2, item.id, filtro, criterio)">
                            <i class="fas fa-check"></i> Activar
                          </button>
                        </template>                           
                        
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div class="clearfix d-flex justify-content-start">
                  <ul class="pagination pagination-sm m-0 float-right">
                    <li class="page-item" v-if="pageNumber > 0">
                      <a href="#" class="page-link" @click.prevent="prevPage">Ant</a>
                    </li>
                    <li class="page-item" v-for="(page, index) in pagesList" :key="index" :class="[page == pageNumber ? 'active' : '']">
                      <a href="#" class="page-link" @click.prevent="selectPage(page)"> {{ page+1 }} </a>
                    </li>
                    <li class="page-item" v-if="pageNumber < pageCount - 1">
                      <a href="#" class="page-link" @click.prevent="nextPage">Post</a>
                    </li>
                  </ul>
                </div>
              </template>
            </div>
          </div>
          
        <div id="container-floating" v-tooltip.left="'Crear nuevo usuario'">
            <router-link :to="'/usuario/crear'">
                <div id="floating-button">
                    <p class="plus">+</p>
                    <div class="plusH">
                        <i class="fas fa-user-plus"></i>
                    </div>
                </div>
            </router-link>
        </div>
        </div>
      </div>
    </div>
</template>

<script>
  export default {
    data(){
      return {
        listUsuario: [],
        opciones: [{
          value: 'firstname',
          label: 'Nombre'
        }, {
          value: 'lastname',
          label: 'Apellido'
        }, {
          value: 'email',
          label: 'Correo electronico'
        }, {
          value: 'a',
          label: 'Activo'
        }, {
          value: 'i',
          label: 'Inactivo'
        },],
        filtro: '',
        criterio: '',
        pageNumber: 0,
        perPage: 15,
        fullscreenLoading: false
      }
    },
    mounted(){
      this.getListarUsuarios('', '');
    },
    computed: {
      //Obtener el numero de pagina
      pageCount(){
        let a = this.listUsuario.length,
            b = this.perPage;
        return Math.ceil(a / b);
      },
      //Obtener registros paginados
      listarUsuariosPaginated(){
        let inicio = this.pageNumber * this.perPage,
            fin = inicio + this.perPage;
        return this.listUsuario.slice(inicio, fin);
      },
      pagesList(){
        let a = this.listUsuario.length,
            b = this.perPage;
        let pageCount = Math.ceil(a / b);
        let count = 0,
            pagesArray = [];

        // 0 < 4 => 0
        // 1 < 4 => 0, 1
        // 2 < 4 => 0, 1, 2
        // 3 < 4 => 0, 1, 2, 3  
        while (count < pageCount) {
          pagesArray.push(count);
          count++;
        }
        return pagesArray;
      }
    },
    methods: {
      limpiarBandejaUsuarios(){
        this.listUsuario = [];
      },
      getListarUsuarios(filtro, criterio){
        this.fullscreenLoading = true;

        var url = '/administracion/usuario/getListarUsuarios?filtro=' + filtro +'&criterio=' + criterio;
        axios.get(url).then(response => {
          this.inicializarPaginacion();
          console.log(response);
          this.listUsuario = response.data;
          this.fullscreenLoading = false;
        })
      },
      nextPage(){
        this.pageNumber++;
      },
      prevPage(){
        this.pageNumber--;
      },
      selectPage(pages){
        this.pageNumber = pages;
      },
      inicializarPaginacion(){
        this.pageNumber = 0;
      },
      setCambiarEstadoUsuario(opc, id, filtro, criterio){
        Swal.fire({
          title: '¿Está seguro de ' + ((opc == 1) ? 'desactivar' : 'activar') + ' el usuario?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: ((opc == 1) ? 'Sí, desactivar' : 'Sí, activar')
        }).then((result) => {
          if (result.value) {
            //Aqui ira la confirmacion del boton, es decir, la peticion al servidor
            this.fullscreenLoading = true;
            
            var url = '/administracion/usuario/setCambiarEstadoUsuario'
            axios.put(url, {
              'id': id
            }).then(response => {
              Swal.fire({
                icon: 'success',
                title: 'Se ' + ((opc == 1) ? 'desactivó' : 'activó') + ' el usuario',
                showConfirmButton: false,
                timer: 1500
              })

              this.getListarUsuarios(filtro, criterio);
            })
          }
        })
      }
    }
  }
</script>

<style>
  #vs1__combobox{
      height: 40px;
  }
  #container-floating {
    position: fixed;
    width: 70px;
    height: 70px;
    bottom: 30px;
    right: 30px;
    z-index: 50;
  }
  #container-floating #floating-button {
    width: 55px;
    height: 55px;
    border-radius: 50%;
    background: #007bff;
    position: fixed;
    bottom: 30px;
    right: 30px;
    cursor: pointer;
    box-shadow: 0px 2px 5px #bcbcbc;
  }

  #container-floating #floating-button .plus {
    color: white;
    position: absolute;
    top: 0;
    display: block;
    bottom: 0;
    left: 0;
    right: 0;
    text-align: center;
    padding: 0;
    margin: 0;
    line-height: 55px;
    font-size: 38px;
    font-family: 'Roboto';
    font-weight: bold;
    animation: plus-out 0.3s;
    transition: all 0.3s;
  }
  #container-floating #floating-button .plusH {
    font-size: 24px;
    color: white;
    padding: 10px 0px 0px 0px;
    text-align: center;
    display: block;
    opacity: 0;

    transition: all 0.3s;
    animation: edit-out 0.3s;
  }
  #container-floating :hover  #floating-button .plus{
    display: none;
  }
  #container-floating :hover #floating-button .plusH:hover {
    opacity: 1 !important;
  }
</style>