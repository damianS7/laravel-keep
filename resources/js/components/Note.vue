<template>
  <div class="col-sm-3">
    <div class="card text-white mb-3" :class="'bg-primary'" style="max-width: 20rem;">
      <div class="card-header">
        <button
          v-on:click="deleteParentNode()"
          type="button"
          class="close"
          data-dismiss="alert"
        >&times;</button>
        <input
          type="text"
          class="form-control edit-input"
          v-model="stateTitle"
          v-on:change="updateDB()"
          v-on:input="updateParentNote()"
        />
      </div>
      <div class="card-body">
        <textarea
          class="card-text edit-textarea"
          v-model="stateBody"
          v-on:change="updateDB()"
          v-on:input="updateParentNote()"
        ></textarea>
      </div>
    </div>
  </div>
</template>
<script>
// Boton X en la nota para eliminar
// Ordenar las notas segun el orden de la db
// Implementar movimiento de notas para cambiar orden
// Implementar cambio de color (Cuadradito con un color y al pinchar mostrar Hex color selector)
// Get CSRF TOKEN DEL META.
// Get ID de la nota
// _method = PUT
// Actualizar enviado datos por post usando axios
export default {
  props: {
    id: { type: Number, required: true },
    index: { type: Number, required: true },
    title: { type: String, required: true },
    body: { type: String, required: true },
    bgcolor: { type: String, required: true },
    order: { type: Number, required: true }
  },
  data: function() {
    return {
      dragging: false,
      stateTitle: this.title,
      stateBody: this.body,
      stateBgColor: this.bgcolor,
      stateOrder: this.order
    };
  },
  methods: {
    deleteParentNode() {
      this.$emit("delete", this.index);
    },
    updateParentNote() {
      this.$emit(
        "update",
        this.index,
        this.stateTitle,
        this.stateBody,
        this.stateBgColor,
        this.stateOrder
      );
    },
    updateDB() {
      this.$emit("save", this.index);
    }
  },
  watch: {
    /** listen to input field with content, emit event when changed **/
    stateTitle(newText, oldText) {
      if (newText !== oldText) {
        //this.$emit("update_note", this.index);
      }
    }
  },
  computed: {},
  mounted() {
    console.log("Component Note mounted.");
  }
};
</script>
<style>
.edit-input,
.edit-textarea {
  background-color: transparent;
  border: none;
  color: white;
  width: 100%;
  height: 100%;
}
.card-body {
  padding: 5px;
  min-height: 160px;
}
</style>