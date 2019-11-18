<template>
  <div class="row">
    <note :title="note.title" :body="note.body" v-for="note of notes"></note>
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
    mymethod1() {}
  },
  components: {
    appNote: Note
  },
  mounted() {
    console.log("Component mounted!!");
    axios.get("http://127.0.0.1:8000/notes").then(response => {
      this.notes = response["data"];
    });
  }
};
</script>
