<h4 class="py-2">Câu hỏi thường gặp</h4>
<div class="card faqs">
    <div class="card-body row m-0  p-2">
        <div class="col-12 p-2 mb-0 faqs_list">
            <div class="faqs_item border-bottom pb-1 mb-2">
                <div class="mb-2 form-group">
                    <div class="d-flex justify-content-between mb-1">
                        <label ><span class="index">1</span>. Câu hỏi </label>
                        <button class="btn btn-danger btn-sm faqs_delete"><i class="fa-regular fa-trash-can"></i></button>
                    </div>
                    <input type="text" class="form-control" name="faqs[0][question]" placeholder="Câu hỏi"></input>
                    <div class="input-error"></div>
                </div>
                <div class="mb-2 form-group">
                    <label >Trả lời</label>
                    <textarea class="form-control"  name="faqs[0][reply]" placeholder="Trả lời"></textarea>
                    <div class="input-error"></div>
                </div>
            </div>
        </div>
        <div class="form-group col-12 p-2 mb-0 ">
            <button  class="btn btn-primary faqs_add float-right">
                <i class="fa-sharp fa-solid fa-plus"></i> 
                Thêm câu hỏi
            </button>
        </div>
    </div>
</div>
<script>
    // ======================== start faqs ================================
    const faqsEl = '.faqs'
    let faqsIndex = 1;
    $('.faqs_add').on('click',function(e){//add faqs
        e.preventDefault();
        const itemClone       = $(faqsEl).find('.faqs_item').first().clone()
        $(itemClone).find('input, textarea').val('');
        $(itemClone).find('input[name^="faqs["], textarea[name^="faqs["]').each(function() {
            const currentName = $(this).attr('name');
            let newField      = currentName.includes('[question]') ? 'question' : 'reply';
            const newName     = currentName.replace(/\[0\]/, `[${faqsIndex}]`).replace(/\[question\]/, `[${newField}]`);
            $(this).attr('name', newName);
        });
        $('.faqs_list').append(itemClone)
        updateIndex()
        faqsIndex++
    })
    $(faqsEl).on('click','.faqs_delete',function(e){//delete faqs
        e.preventDefault();
        if($(faqsEl).find('.faqs_item').length >1){
            $(this).closest('.faqs_item')?.remove()
            updateIndex()
        }
    })
    function updateIndex(){
        $(faqsEl+' .index').each(function(index,el){
            $(this).text(index+1)
        })
    }
    // ======================== end faqs ================================
</script>