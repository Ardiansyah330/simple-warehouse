<div class="mb-3">
    <label class="block text-sm font-medium mb-1">Name</label>
    <input type="text" name="name" x-model="editData.name" class="w-full border rounded px-3 py-2" required>
</div>
<div class="mb-3">
    <label class="block text-sm font-medium mb-1">Email</label>
    <input type="email" name="email" 
           :value="editData.email" 
           class="w-full border rounded px-3 py-2">
</div>
<div class="mb-3">
    <label class="block text-sm font-medium mb-1">Phone</label>
    <input type="text" name="phone" 
           :value="editData.phone" 
           class="w-full border rounded px-3 py-2">
</div>
<div class="mb-3">
    <label class="block text-sm font-medium mb-1">Address</label>
    <textarea name="address" 
              x-text="editData.address" 
              class="w-full border rounded px-3 py-2"></textarea>
</div>

