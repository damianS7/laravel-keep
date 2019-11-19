<template>
  <div class="col-sm-3">
    <div class="card text-white mb-3" :class="stateBgColor">
      <div class="card-header">
        <div class="row">
          <div class="col-sm-8">
            <button
              class="note-color-selector note-color-green"
              v-on:click="changeNoteColor('note-color-green')"
            >&nbsp;</button>
            <button
              v-bind:color="stateBgColor"
              class="note-color-selector note-color-blue"
              v-on:click="changeNoteColor('note-color-blue')"
            >&nbsp;</button>
            <button
              class="note-color-selector note-color-red"
              v-on:click="changeNoteColor('note-color-red')"
            >&nbsp;</button>
            <button
              class="note-color-selector note-color-black"
              v-on:click="changeNoteColor('note-color-black')"
            >&nbsp;</button>
            <button
              class="note-color-selector note-color-grey"
              v-on:click="changeNoteColor('note-color-grey')"
            >&nbsp;</button>
            <button
              class="note-color-selector note-color-yellow"
              v-on:click="changeNoteColor('note-color-yellow')"
            >&nbsp;</button>
            <button
              class="note-color-selector note-color-darkblue"
              v-on:click="changeNoteColor('note-color-darkblue')"
            >&nbsp;</button>
          </div>
          <div class="col-sm-4">
            <button
              v-on:click="deleteParentNode()"
              type="button"
              class="close"
              data-dismiss="alert"
            >&times;</button>
          </div>
        </div>
        <div class="row mt-2">
          <div class="col-sm">
            <input
              type="text"
              class="form-control edit-input"
              v-model="stateTitle"
              v-on:change="updateDB()"
              v-on:input="updateParentNote()"
            />
          </div>
        </div>
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
// Implementar cambio de color (Cuadradito con un color y al pinchar mostrar Hex color selector)
// Ordenar las notas segun el orden de la db
// Implementar movimiento de notas para cambiar orden
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
    changeNoteColor(classColor) {
      this.stateBgColor = classColor;
      this.updateParentNote();
      this.updateDB();
    },
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
    //console.log("Component Note mounted.");
  }
};
</script>
<style>
.edit-input,
.edit-textarea {
  background-color: transparent;
  border: none;
  width: 100%;
  height: 100%;
}
.card-body {
  padding: 5px;
  min-height: 160px;
}
.note-color-selector {
  height: 15px;
  width: 15px;
  padding: 0;
  max-width: 15px !important;
  border: 2px solid white;
  display: inline-block;
}
.note-color-selector:focus {
  outline: none;
}
.note-color-green {
  background-color: #28a745;
}
.note-color-blue {
  background-color: #d1ecf1;
}

.note-color-darkblue {
  background-color: #328bd5;
}

.note-color-black .edit-input,
.note-color-black .edit-textarea {
  color: white;
}

.note-color-black {
  background-color: #343a40;
  color: white;
}

.note-color-grey {
  background-color: #e2e3e5;
  color: black;
}

.note-color-red {
  background-color: #c82333;
}

.note-color-yellow {
  background-color: #fff3cd;
  color: black;
}
</style>