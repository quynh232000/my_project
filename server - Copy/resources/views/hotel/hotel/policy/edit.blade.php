 
<div class="border-top">
    <h4 class="py-2">Câu hỏi thường gặp</h4>
    <div class="card faqs">
        <div class="card-body p-3">
            <div class=" faqs_list">
                @forelse ($params['item']['faqs'] as $item)
                    <div class="faqs_item border-bottom pb-1 mb-2">
                        <input type="text" hidden name="faqs_item[]" value="{{$item['id']}}">
                        <div class="mb-2 form-group">
                            <div class="d-flex justify-content-between mb-1">
                                <label ><span class="index">{{$loop->index +1}}</span>. Câu hỏi </label>
                                <button class="btn btn-danger btn-sm faqs_delete"><i class="fa-regular fa-trash-can"></i></button>
                            </div>
                            <input type="text" class="form-control" value="{{$item['question']}}" name="faqs_current[{{$item['id']}}][question]" placeholder="Câu hỏi"></input>
                            <div class="input-error"></div>
                        </div>
                        <div class="mb-2 form-group">
                            <label >Trả lời</label>
                            <textarea class="form-control"  name="faqs_current[{{$item['id']}}][reply]"  placeholder="Trả lời">{{$item['reply']}}</textarea>
                            <div class="input-error"></div>
                        </div>
                    </div>
                @empty
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
                @endforelse
                
            </div>
            <div class="form-group ">
                <button  class="btn btn-primary faqs_add float-right">
                    <i class="fa-sharp fa-solid fa-plus"></i> 
                    Thêm câu hỏi
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // ======================== start faqs ================================
    const faqsEl        = '.faqs'
    const itemCloneTemp = `<div class="faqs_item border-bottom pb-1 mb-2">
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
                        </div>` 

    let faqsIndex       = 1;
    
    $('.faqs_add').on('click',function(e){//add faqs
        e.preventDefault();
        const itemClone       = $(itemCloneTemp)
        $(itemClone).find('input[name^="faqs["], textarea[name^="faqs["]').each(function() {
            const currentName = $(this).attr('name');
            let newField      = currentName.includes('[question]') ? 'question' : 'reply';
            const newName     = currentName.replace(/\[0\]/, `[${faqsIndex}]`).replace(/\[question\]/, `[${newField}]`);
            $(this).attr('name', newName);
            console.log(newName);
            
        });
        $('.faqs_list').append(itemClone)
        updateIndex()
        faqsIndex++
    })
    $(faqsEl).on('click','.faqs_delete',function(){//delete faqs
        $(this).closest('.faqs_item')?.remove()
        if($(faqsEl+' .faqs_item').length == 0){
            $('.faqs_list').append(itemClone)
        }
        updateIndex()
    })
    function updateIndex(){// update index question
        $(faqsEl+' .index').each(function(index,el){
            $(this).text(index+1)
        })
    }
    // ======================== end faqs ================================
</script>