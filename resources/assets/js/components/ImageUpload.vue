<template>

    <div class="file" style="margin-right: 20px;">
        <label class="file-label">
            <input class="file-input" type="file" accept="image/*" @change="onChange">
            <span class="file-cta">
                 <span class="file-icon">
                 <i class="fas fa-upload"></i>
             </span>
             <span class="file-label btn">
               آپلود عکس
             </span>
          </span>
        </label>
    </div>

</template>

<script>
    export default {
        name: "image-upload",

        methods: {
            onChange(e) {

                if (!e.target.files.length) return;
                let file = e.target.files[0];
                let reader = new FileReader();
                reader.readAsDataURL(file);

                reader.onload = e => {

                    let src = e.target.result;

                    this.$emit('loaded', {src, file});

                };

            },
        }
    }
</script>

<style scoped>

</style>