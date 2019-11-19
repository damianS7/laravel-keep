<template>
  <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
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
            <button
              class="note-color-selector note-color-aqua"
              v-on:click="changeNoteColor('note-color-aqua')"
            >&nbsp;</button>
            <button
              class="note-color-selector note-color-pie"
              v-on:click="changeNoteColor('note-color-pie')"
            >&nbsp;</button>
            <button
              class="note-color-selector note-color-purple"
              v-on:click="changeNoteColor('note-color-purple')"
            >&nbsp;</button>
            <button
              class="note-color-selector note-color-stone"
              v-on:click="changeNoteColor('note-color-stone')"
            >&nbsp;</button>
            <button
              class="note-color-selector note-color-orange"
              v-on:click="changeNoteColor('note-color-orange')"
            >&nbsp;</button>
            <button
              class="note-color-selector note-color-aqua2"
              v-on:click="changeNoteColor('note-color-aqua2')"
            >&nbsp;</button>

            <button
              class="note-color-selector note-color-green2"
              v-on:click="changeNoteColor('note-color-green2')"
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
}

.note-color-grey {
  background-color: #e2e3e5;
}

.note-color-red {
  background-color: #c82333;
}

.note-color-yellow {
  background-color: #fff3cd;
}

.note-color-aqua {
  background-color: #17a2b8;
}
.note-color-pie {
  background-color: #e0a800;
}
.note-color-purple {
  background-color: #bf73cc;
}
.note-color-stone {
  background-color: #8e8c84;
}
.note-color-orange {
  background-color: #bd5916;
}

.note-color-aqua2 {
  background-color: #75caeb;
}

.note-color-green2 {
  background-color: #82d069;
}
</style>