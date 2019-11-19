<template>
  <div class="container mt-3">
    <div class="row mb-3">
      <div class="col-sm">
        <button v-on:click="addNote()" class="btn btn-primary">ADD NOTE</button>
      </div>
    </div>

    <div class="row">
      <note
        v-for="(note, index) of notes"
        v-bind:index="index"
        v-bind:key="note.id"
        :id="note.id"
        :bgcolor="note.bgcolor"
        :order="note.order"
        :title="note.title"
        :body="note.body"
        :note="note"
        @update="updateNote"
        @save="saveNote"
        @delete="deleteNote"
      ></note>
    </div>
  </div>
</template>

<script>
// Este componente cargara la app. Primero creara un array con las notas
// y luego ira imprimirandolas de 4 en 4. Intersantado una row cada 4 columnas
// Implementar el mover notas
import Note from "./Note";
export default {
  data: function() {
    return {
      notes: []
    };
  },
  methods: {
    addNote() {
      var notes = this.notes;

      axios
        .post("http://127.0.0.1:8000/notes", {
          data: { order: "0" }
        })
        .then(function(response) {
          notes.push(response);
        });
    },
    deleteNote(note_index) {
      //console.log("Se va a borrar la note: " + note_index);
      var notes = this.notes;
      var note = this.notes[note_index];

      // Enviamos la peticion al backend
      axios
        .post("http://127.0.0.1:8000/notes/" + note.id, {
          _method: "delete"
        })
        .then(function(response) {
          notes.splice(note_index, 1);
        });
    },
    updateNote(index, title, body, bgcolor, order) {
      // Actualizamos la nota usando los datos recibidos del child (Note)
      this.notes[index].title = title;
      this.notes[index].body = body;
      this.notes[index].bgcolor = bgcolor;
      this.notes[index].order = order;
    },
    saveNote(note_index) {
      var note = this.notes[note_index];
      // Enviamos la peticion al backend
      axios.post("http://127.0.0.1:8000/notes/" + note.id, {
        data: note,
        _method: "put"
      });
    }
  },
  components: {
    appNote: Note
  },
  mounted() {
    // Cuando se termina de inicializar la app, realizamos una peticion
    // al backend para obtener las notas
    axios.get("http://127.0.0.1:8000/notes").then(response => {
      this.notes = response["data"];
    });
  }
};
</script>
