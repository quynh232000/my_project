

function SkeProductSale() {
  return (
    <div className="bg-white rounded-lg shadow-lg relative animate-pulse ">
  <span className="absolute top-0 left-0 z-[1] bg-yellow-300 px-6 py-2 h-6 w-20 rounded-tl-lg rounded-br-lg"></span>
  <span className="absolute top-1 right-1 z-[1] h-5 w-5 bg-yellow-300 rounded-full"></span>

  <div className="overflow-hidden">
    <div className="w-full h-[180px] bg-gray-200 rounded-t-lg"></div>
  </div>

  <div className="p-3 flex flex-col justify-between">
    <div className="flex flex-col gap-2">
      <div className="h-[46px] bg-gray-200 rounded w-full"></div>

      <div className="flex gap-1 h-3">
        {[...Array(5)].map((_, i) => (
          <div key={i} className="h-3 w-3 bg-yellow-300 rounded-sm"></div>
        ))}
      </div>

      <div className="flex gap-2 items-center">
        <div className="h-4 w-4 bg-gray-300 rounded-full"></div>
        <div className="h-4 bg-gray-200 rounded w-3/4"></div>
      </div>

      <div className="flex gap-2">
        <div className="flex items-center gap-2 bg-primary-100 px-1 rounded-sm">
          <div className="h-4 w-4 bg-primary-300 rounded-full"></div>
          <div className="h-4 w-6 bg-primary-300 rounded"></div>
        </div>
        <div className="h-4 w-32 bg-gray-200 rounded"></div>
      </div>
    </div>

    <div className="text-right mt-5 flex justify-end items-center gap-4">
      <div className="h-4 w-12 bg-gray-300 rounded"></div>
      <div className="h-6 w-20 bg-primary-300 rounded"></div>
    </div>
  </div>
</div>

  )
}

export default SkeProductSale