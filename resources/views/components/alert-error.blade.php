<div class="alert-error">
    {{ $message }}
</div>
<style>
    .alert-error {
        background-color: #dc3545; /* Red */
        color: white;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 5px;
        text-align: center;
        font-size: 16px;
    }
</style>
<script>
    setTimeout(function() {
        document.querySelector('.alert-error').style.display = 'none';
    }, 5000); // 5 seconds
    
</script>
