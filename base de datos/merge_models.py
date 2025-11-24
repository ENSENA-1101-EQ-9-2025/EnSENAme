import json
import os

def merge_json_models(main_file, source_file):
    print(f"Loading main model: {main_file}")
    with open(main_file, 'r', encoding='utf-8') as f:
        main_data = json.load(f)

    print(f"Loading source model: {source_file}")
    with open(source_file, 'r', encoding='utf-8') as f:
        source_data = json.load(f)

    # Ensure structure exists
    if 'examples' not in main_data:
        main_data['examples'] = {}
    if 'classNames' not in main_data:
        main_data['classNames'] = []

    source_examples = source_data.get('examples', {})
    count_merged = 0

    print("Merging examples...")
    for label, examples in source_examples.items():
        if label not in main_data['examples']:
            main_data['examples'][label] = []
        
        # Append examples
        main_data['examples'][label].extend(examples)
        count_merged += len(examples)
        print(f"  - Added {len(examples)} examples to class '{label}'")

    # Update classNames
    all_keys = list(main_data['examples'].keys())
    main_data['classNames'] = sorted(all_keys)
    
    print(f"Total examples merged: {count_merged}")
    print(f"Total classes: {len(main_data['classNames'])}")

    print(f"Saving merged model to: {main_file}")
    with open(main_file, 'w', encoding='utf-8') as f:
        json.dump(main_data, f)
    
    print("Done!")

if __name__ == "__main__":
    base_dir = os.path.dirname(os.path.abspath(__file__))
    main_path = os.path.join(base_dir, "datos_entrenamiento_senas (3).json")
    source_path = os.path.join(base_dir, "modelo_simplificado.json")
    
    merge_json_models(main_path, source_path)
