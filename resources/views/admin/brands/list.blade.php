  <table class="table table-bordered table-striped">
      <thead class="table-light">
          <tr>
              <th>STT</th>
              <th>Tên thương hiệu</th>
              <th>Mô tả</th>
              <th></th>
          </tr>
      </thead>
      <tbody>
          @foreach ($list as $item)
              <tr>
                  <td>{{ $loop->index + 1 }}</td>
                  <td>{{ $item->brandname }}</td>
                  <td>{{ $item->description }}</td>
                  <td>
                      <div class="d-flex">
                          <a href="{{ route('brand.edit', $item->id) }}" class="btn btn-warning mx-1">sửa</a>
                          <form action="{{ route('brand.delete', $item->id) }}" method="POST">
                              @csrf
                              <button type="submit" class="btn btn-danger mx-1">xóa</button>
                          </form>
                          <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                              data-bs-target = "#confirmdelete" data-info="{{ $item->brandname }}"
                              data-action="{{ route('brand.delete', $item->id) }}">
                              Xóa (modal)
                          </button>
                      </div>
                  </td>
              </tr>
          @endforeach
      </tbody>
  </table>


  {{ $list->links('pagination::bootstrap-4') }}
