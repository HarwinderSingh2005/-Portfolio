<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * One generic CRUD controller for every admin section.
 * The section list, fields and validation come from config/admin.php.
 */
class AdminResourceController extends Controller
{
    private function definition(string $resource): array
    {
        $definition = config("admin.resources.$resource");
        abort_unless(is_array($definition), 404);

        return $definition;
    }

    private function ensureWritable(array $definition): void
    {
        abort_if(! empty($definition['readonly']), 403);
    }

    public function dashboard()
    {
        $resources = config('admin.resources');
        $counts = [];

        foreach ($resources as $key => $definition) {
            $model = $definition['model'];
            $counts[$key] = $model::count();
        }

        return view('admin.dashboard', compact('resources', 'counts'));
    }

    public function index(string $resource)
    {
        $definition = $this->definition($resource);

        if (! empty($definition['singleton'])) {
            $model = $definition['model'];
            $row = $model::firstOrCreate(['id' => 1]);

            return redirect()->route('admin.resource.edit', [$resource, $row->id]);
        }

        $model = $definition['model'];
        $rows = $model::query()
            ->orderBy($definition['order'] ?? 'id', $definition['dir'] ?? 'asc')
            ->get();

        return view('admin.index', compact('resource', 'definition', 'rows'));
    }

    public function create(string $resource)
    {
        $definition = $this->definition($resource);
        $this->ensureWritable($definition);

        $model = $definition['model'];

        return view('admin.form', [
            'resource' => $resource,
            'definition' => $definition,
            'row' => new $model(),
            'action' => route('admin.resource.store', $resource),
            'method' => 'POST',
        ]);
    }

    public function store(Request $request, string $resource)
    {
        $definition = $this->definition($resource);
        $this->ensureWritable($definition);

        $model = $definition['model'];
        $model::create($this->validatedData($request, $definition));

        return redirect()->route('admin.resource.index', $resource)
            ->with('status', 'Saved successfully.');
    }

    public function edit(string $resource, int $id)
    {
        $definition = $this->definition($resource);
        $this->ensureWritable($definition);

        $model = $definition['model'];
        $row = $model::findOrFail($id);

        return view('admin.form', [
            'resource' => $resource,
            'definition' => $definition,
            'row' => $row,
            'action' => route('admin.resource.update', [$resource, $row->id]),
            'method' => 'PUT',
        ]);
    }

    public function update(Request $request, string $resource, int $id)
    {
        $definition = $this->definition($resource);
        $this->ensureWritable($definition);

        $model = $definition['model'];
        $row = $model::findOrFail($id);
        $row->update($this->validatedData($request, $definition));

        return redirect()->route('admin.resource.index', $resource)
            ->with('status', 'Updated successfully.');
    }

    public function destroy(string $resource, int $id)
    {
        $definition = $this->definition($resource);
        $model = $definition['model'];
        $model::findOrFail($id)->delete();

        return redirect()->route('admin.resource.index', $resource)
            ->with('status', 'Deleted successfully.');
    }

    /**
     * Validates the request using config rules and converts it into model attributes.
     */
    private function validatedData(Request $request, array $definition): array
    {
        $rules = [];
        foreach ($definition['fields'] as $name => $field) {
            $rules[$name] = $field['rules'] ?? 'nullable';
        }

        $validated = $request->validate($rules);
        $data = [];

        foreach ($definition['fields'] as $name => $field) {
            if ($field['type'] === 'image') {
                // Only replace the image when a new file was uploaded.
                if ($request->hasFile($name)) {
                    $data[$name] = '/storage/'.$request->file($name)->store('uploads', 'public');
                }
                continue;
            }

            if ($field['type'] === 'lines') {
                $lines = preg_split('/\R/', (string) ($validated[$name] ?? '')) ?: [];
                $data[$name] = array_values(array_filter(array_map('trim', $lines), fn ($line) => $line !== ''));
                continue;
            }

            $data[$name] = $validated[$name] ?? null;
        }

        if (array_key_exists('sort_order', $data)) {
            $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        }

        return $data;
    }
}
