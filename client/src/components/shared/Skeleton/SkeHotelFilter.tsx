

function SkeHotelFilter() {
  return (
    <div className='border p-3 rounded-lg bg-white flex gap-4 animate-pulse'>
  <div className='relative w-[230px] h-[180px] bg-gray-300 rounded-lg'>
    <span className='absolute top-2 right-2 w-5 h-5 bg-gray-300 rounded-full'></span>
  </div>
  <div className='flex flex-col gap-2 flex-1'>
    <div className='h-5 bg-gray-300 rounded w-2/3'></div>
    <div className='flex gap-2'>
      <div className='w-10 h-5 bg-gray-300 rounded'></div>
      <div className='w-20 h-5 bg-gray-300 rounded'></div>
      <div className='w-24 h-5 bg-gray-300 rounded'></div>
    </div>
    <div className='flex items-center gap-2'>
      <div className='w-5 h-5 bg-gray-300 rounded-full'></div>
      <div className='w-3/4 h-4 bg-gray-300 rounded'></div>
    </div>
    <div className='bg-gray-50 w-full p-2 flex flex-col gap-2'>
      <div className='flex justify-between items-center text-[12px]'>
        <div className='w-20 h-4 bg-gray-300 rounded'></div>
        <div className='flex items-center gap-2'>
          <div className='w-40 h-5 bg-gray-300 rounded'></div>
          <div className='w-10 h-5 bg-gray-300 rounded'></div>
        </div>
      </div>
      <div className='flex justify-end gap-2 items-center'>
        <div className='w-12 h-4 bg-gray-300 rounded'></div>
        <div className='w-20 h-6 bg-gray-300 rounded'></div>
      </div>
      <div className='flex justify-end'>
        <div className='w-32 h-9 bg-gray-300 rounded-lg'></div>
      </div>
    </div>
  </div>
</div>

  )
}

export default SkeHotelFilter