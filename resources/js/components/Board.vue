<template>
  <div class="container mt-3">
    <div class="row mb-3">
      <div class="col-sm">
        <button v-on:click="createNote()" class="btn btn-primary">+</button>
      </div>
    </div>

    <draggable
      v-model="notes"
      @end="onEnd"
      :options="{filter: 'textarea, input', preventOnFilter: false}"
    >
      <transition-group class="row" name="fade" tag="div">
        <note
          v-for="(note, index) of notes"
          v-bind:key="note.id"
          v-bind:index="index"
          :id="note.id"
          :title="note.title"
          :body="note.body"
          :bgcolor="note.bgcolor"
          :order="index"
          @update="updateNote"
          @save="saveNote"
          @delete="deleteNote"
        ></note>
      </transition-group>
    </draggable>
  </div>
</template>

<script>
import Note from "./Note";
import draggable from "vuedraggable";
export default {
  data: function() {
    return {
      notes: []
    };
  },
  methods: {
    // Metodo para crear las notas
    createNote() {
      var vm = this;

      // Enviamos la peticion al backend
      axios.post("http://127.0.0.1:8000/notes", {}).then(function(response) {
        // Si el request tuvo exito (codigo 200)
        if (response.status == 201) {
          // Agregamos la nota al board
          vm.notes.push(response["data"]);
          vm.reAssignOrder();
        }
      });
    },
    // Metodo para borrar notas
    deleteNote(note_index) {
      var vm = this;
      var note = vm.notes[note_index];

      // Enviamos la peticion al backend
      axios
        .post("http://127.0.0.1:8000/notes/" + note.id, {
          _method: "delete"
        })
        .then(function(response) {
          // Si el request tuvo exito (codigo 200)
          if (response.status == 204) {
            // Borramos la nota del board
            vm.notes.splice(note_index, 1);
            vm.reAssignOrder();
          }
        });
    },
    // Actualiza una nota
    updateNote(index, title, body, bgcolor, order) {
      // Actualizamos la nota usando los datos recibidos del child (Note)
      this.notes[index].title = title;
      this.notes[index].body = body;
      this.notes[index].bgcolor = bgcolor;
      this.notes[index].order = order;
    },
    // Guarda la nota en la DB
    saveNote(note_index) {
      var note = this.notes[note_index];
      // Enviamos la peticion al backend
      axios.post("http://127.0.0.1:8000/notes/" + note.id, {
        data: note,
        _method: "put"
      });
    },
    // Metodo que se ejecuta cuando movemos una nota.
    onEnd(evt) {
      // Cuando el programa llega aqui, las notas han sido reordenadas
      // en el array de la app (data.notes). Aunque el campo note.order
      // permanece sin actualizar.
      // Reasignamos el orden de las notas
      this.reAssignOrder();
    },
    // Este metodo actualiza note.order y le asigna el mismo orden del array
    reAssignOrder() {
      // Iteracion sobre el array de las notas
      for (var [index, note] of Object.entries(this.notes)) {
        // Si el orden asignado en note.order difiere de su poscion en el array
        if (note.order != index) {
          // Actualizamos el orden
          note.order = index;
          // Guardamos la nota
          this.saveNote(index);
        }
      }
    }
  },
  computed: {
    // Ordena el array
    sortedNotes: function() {
      //return this.notes.sort(function(a, b) {
      //  return parseInt(a.order) > parseInt(b.order);
      //});
    }
  },
  mounted() {
    var vm = this;
    // Cuando se termina de inicializar la app, realizamos una peticion
    // al backend para obtener las notas
    axios.get("http://127.0.0.1:8000/notes/").then(function(response) {
      // Si el request tuvo exito (codigo 200)
      if (response.status == 200) {
        // Agregamos las notas al array
        vm.notes = response["data"];
        vm.reAssignOrder();
      }
    });
  },
  components: {
    Note,
    draggable
  }
};
</script>
<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 1s;
}
.fade-enter,
.fade-leave-to {
  opacity: 0;
}
</style>