<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Cache;

class Organogram extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'parent_id',
        'name_en',
        'name_bn',
        'is_active',
        'office_type',
        'division_region_id',
        'district_id',
        'upazila_id',
        'union_id',
        'code',
        'address',
        'phone',
        'fax',
        'is_inventory_center',

        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

     /**
     * Scope a query to only include active office.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    /**
     * Scope a query to only include office of a given type (Region, District, Upazila office).
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('office_type', $type);
    }

    public function scopeOrganization($query) 
    {
        $user = Auth::user();
        if(!empty($user->organization_id)) {
            $query = $query->where ('organization_id', $user->organization_id)
                            ->orWhereNull ('organization_id');
        }
        return $query;
    }

    public function scopeOrganogram($query) 
    {
        $user = Auth::user();
        $permittedOffice = $user->organograms()->get()->pluck('id')->toArray();
        if(auth()->user()->user_level === 'organization_admin' ||
            auth()->user()->user_level === 'super_admin' ||
            auth()->user()->user_level === 'pmu'
        ) {   // Showing all organogram office for admin
            return $query;
        } else {    // Showing only permitted organogram for other user
            $query = $query->whereIn('id', $permittedOffice);
        }
        return $query;
    }

    public function saveOrUpdate($organogramInput, $id = null)
    {
        $organogramInput['organization_id'] = Auth::user()->organization_id;
        //dd(Auth::user()->organization_id);
        if(is_null($id)) {
            $organogramInput['created_by'] = Auth::id();
            Organogram::create($organogramInput);
            self::clearCache();
        } else {
            $organogram = Organogram::find($id);
            $organogramInput['updated_by'] = Auth::id();
            $organogram->update($organogramInput);
            self::clearCache();
        }
    }


    public function getOrganogramDataTreeList()
    {
        $organograms = [];
        $user = Auth::user();
        //$permittedOffice = $user->organograms()->get()->pluck('id')->toArray();
        if(!empty($user->organization_id)) {
            $organograms = Organogram::active()->organization()->organogram()->get()->toArray();

            //$headOfTheOrganogram  = Organogram::active()->whereParentId(0)->get()->toArray();
            //$organograms = array_merge($headOfTheOrganogram, $organograms);

        }
        return $this->makeOrganogramTreeArray ($organograms);
        
    }

    public function makeOrganogramTreeArray ($organograms)
    {
        $idField = 'id';
        $foreignKey = 'parent_id'; //Set parent id
        $hash = array();
        $result = array();

        // hash to organograms by id
        foreach ($organograms as $row) {
            $hash[$row[$idField]] = $row;
        }
        //dd($hash);
        foreach ($hash as $key=>&$row) {
            
            //dd($parentId);
            $parentId = $row[$foreignKey];

            // If this office has parent id in DB but no permission for this user then set parent id to 0
            if(!array_key_exists($parentId, $hash) && !is_null($parentId) && $parentId != 0) {
                $hash[$key][$foreignKey] = 0;
                $parentId = $row[$foreignKey];
                //dd($row[$foreignKey]);
            }
            

            if (!is_null($parentId) && $parentId != 0) {
                // add items field, if not available
                if ( !in_array('items', $hash[$parentId]) ) {
                    $hash[$parentId] = $hash[$parentId] + array('items' => array());
                }
                // add row to parent item
                $hash[$parentId]['items'][] =& $row;
            }
        }

        foreach ($hash as &$row) {
            $parentId = $row[$foreignKey];

            if (is_null($parentId) || $parentId == 0) {
                $result[] =& $row;
            }
        }
        //dd($result);

        return $result;
    }

     /**
     * Generate organogram tree view for other scope without organogram scope.
     * Generate organogram tree view with jstree library for using to select multiple office in various
     * scope
     */
    public function generateOrganogramTreeviewList($hierarchicalOrganogramData, $treeLists, $selectedId, $name) 
    {
      
       $parentClass = 'nested-parent';

        foreach ($hierarchicalOrganogramData as $organogram) 
        {
            $dataJstree = '{"opened":true,"selected":false, "icon":false}';

            if(in_array($organogram['id'], $selectedId)) {
                $dataJstree = '{"opened":true,"selected":true}';
            }
           
            if(!empty($organogram['items'])) {

                $treeLists .= '<li id="' . $organogram['id'] . '" data-jstree=\'' . $dataJstree . '\' class="treeview-animated-items has-submenu">';
             

                $treeLists .= $organogram[$name];
                $treeLists .= '<ul class="submenu nested ' . $parentClass . '" style="display:inherit;">';
                $treeLists = $this->generateOrganogramTreeviewList($organogram['items'], $treeLists, $selectedId, $name);
               
                $treeLists .= '</ul></li>';

            } else {
                $treeLists .= '<li id="' . $organogram['id'] . '" data-jstree=\'' . $dataJstree . '\' onclick="getOrganogramId(' . $organogram['id']. ', \'' . $organogram[$name] . '\')">';
                
                                    
                $treeLists .= $organogram[$name] .'</li>';
            }
        }
        return $treeLists;
    }

    public function generateOrganogramTreeviewListForOrganogramScope($hierarchicalOrganogramData, $treeLists, $permissions, $name, $showActionButton) 
    {
       $isActiveClass = '';
       $isOpenParent = 'open';
       $parentClass = 'nested-parent';
       $hideParentActionButton = '';

        foreach ($hierarchicalOrganogramData as $organogram) 
        {
            //$isOpenParent = 'open';
            $isActiveClass = '';
           
            if(!empty($organogram['items'])) {
                $isActiveClass = ' active-parent-' . $organogram['id'];

                $treeLists .= '<li class="treeview-animated-items">';
                if($showActionButton) {
                    //$isOpenParent = '';
                    $treeLists .= '<div class="dropdown float-right mt-1 mr-1 %isCapableOneOptionClass%">
                                    <button class="btn btn-secondary btn-sm tree-action-btn dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <button class="dropdown-item small %editCapabilityClass%" mode="edit" organogram-id="' . $organogram['id'] . '" onclick="createForm(event)" type="button"><i class="icon-pencil7 mr-1"></i> Edit Item</button>
                                        <button class="dropdown-item small %addCapabilityClass%" mode="add" organogram-id="' . $organogram['id'] . '" onclick="createForm(event)" type="button"><i class="icon-plus3 mr-1"></i> Add Child</button>
                                    </div>
                                </div>';
                }
                                
                $treeLists .=   '<a onclick="getOrganogramId(' . $organogram['id'] .  ', \'' . $organogram[$name] . '\')" class="treeview-animated-items-header text-decoration-none hover-container closed ' . $isOpenParent . $isActiveClass . '">
                                
                                    <i class="icon-plus-circle2 toggle-icon"></i>
                                    <span>' . $organogram[$name] . '</span>
                                </a>
                               ';
                $treeLists .= '<ul class="nested ' . $parentClass . '" style="display:inherit;">';
                $treeLists = $this->generateOrganogramTreeviewListForOrganogramScope($organogram['items'], $treeLists, $permissions, $name, $showActionButton);
                //dd($treeLists);
                $treeLists .= '</ul></li>';

            } else {
                $isActiveClass = ' active-child-' . $organogram['id'];
                $treeLists .= '<li onclick="getOrganogramId(' . $organogram['id']. ', \'' . $organogram[$name] . '\')">
                                    <div class="treeview-animated-element clearfix hover-container' . $isActiveClass . '">';

                if($showActionButton) {
                    $treeLists .= '<div class="dropdown float-right visible-on-hover %isCapableOneOptionClass%">
                                        <button class="btn btn-secondary btn-sm tree-action-btn dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <form action="' . route('organogram.delete', $organogram['id']) . '" method="POST">
                                            <input type="hidden" name="_token" value="' . csrf_token() . '">'
                                            
                                                . method_field('DELETE') . '
                                                <button class="dropdown-item small text-danger %deleteCapabilityClass%" onclick="return confirm(\'Are you sure?\')" type="submit"><i class="icon-trash mr-1"></i> Delete</button>
                                            </form>
                                            <button class="dropdown-item small %editCapabilityClass%" mode="edit" organogram-id="' . $organogram['id'] . '" onclick="createForm(event)" type="button"><i class="icon-pencil7 mr-1"></i> Edit Item</button>
                                            <button class="dropdown-item small %addCapabilityClass%" mode="add" organogram-id="' . $organogram['id'] . '" onclick="createForm(event)" type="button"><i class="icon-plus3 mr-1"></i> Add Child</button>
                                        </div>
                                    </div>';
                }
                                    
                $treeLists .= '<i class="icon-forward mr-1"></i>' . $organogram[$name] .
                            '</div>
                        </li>';
            }
        }

        return $treeLists;
    }


   
    public function getOrganogramTreeviewList(bool $showActionButton = true,  array $selectedId = []) : string
    {
        $hierarchicalOrganogramData = $this->getOrganogramDataTreeList();
        if(empty($hierarchicalOrganogramData)) {
            return "";
        }
        $lang = config('app.locale');
        $name = "name_{$lang}";

        $cacheKey  = "organograms";
        $cacheKey  = $showActionButton ? $cacheKey . '1' : $cacheKey . '0'; // Here 1 for organogram with action button and 0 for without action button
        $cacheTime = 60 * 24 * 30; //30 days in minutes = minutes x hours x days

        if($showActionButton) { // if true that means tree for only organogram information scope

            $permissions['editCapabilityClass'] = 'd-none';    // User has no permission to edit. So hide edit button
            $permissions['addCapabilityClass'] = 'd-none';     // User has no permission to add. So hide add button
            $permissions['deleteCapabilityClass'] = 'd-none';  // User has no permission to delete. So hide delete button
            $permissions['isCapableOneOptionClass'] = 'd-none';    // Checking if user has capabilities at least one option of add, edit or delete
            
            if( hasUserCap('add_organogram') ) {    // Has permission to add item
                $permissions['addCapabilityClass'] = '';
                $permissions['isCapableOneOptionClass'] = '';
            }
            if( hasUserCap('edit_organogram')) {   // Has permission to edit item
                $permissions['editCapabilityClass'] = '';
                $permissions['isCapableOneOptionClass'] = '';
            }
            if( hasUserCap('delete_organogram') ) { // Has permission to delete item
                $permissions['deleteCapabilityClass'] = '';
                $permissions['isCapableOneOptionClass'] = '';
            }
            
            // $treeLists = Cache::remember($cacheKey, $cacheTime, function () use($hierarchicalOrganogramData, $permissions, $name, $showActionButton) {
                $treeLists = '<div class="treeview-animated"><ul class="treeview-animated-list mb-3">';
                $treeLists = $this->generateOrganogramTreeviewListForOrganogramScope($hierarchicalOrganogramData, $treeLists, $permissions, $name, $showActionButton);
                $treeLists .= '</ul></div>';
                //return $treeLists;
            // });

             // Show hide all action with user access permission by replacing a string
            // Adding d-none class if user has no access permission or $showActionButton var is false
            $treeLists = str_replace('%isCapableOneOptionClass%', $permissions['isCapableOneOptionClass'], $treeLists);
            $treeLists = str_replace('%editCapabilityClass%', $permissions['editCapabilityClass'], $treeLists);
            $treeLists = str_replace('%addCapabilityClass%', $permissions['addCapabilityClass'], $treeLists);
            $treeLists = str_replace('%deleteCapabilityClass%', $permissions['deleteCapabilityClass'], $treeLists);
            // For selecting specific node in edit mode 
            if(!$showActionButton) {
                $parentNode = 'active-parent-'.$selectedId;
                $childNode = 'active-child-'.$selectedId;
                $treeLists = str_replace($parentNode, ' active-header', $treeLists);
                $treeLists = str_replace($childNode, ' opened', $treeLists);
            }
            
        } else {

            // $treeLists = Cache::remember($cacheKey, $cacheTime, function () use($hierarchicalOrganogramData, $name, $selectedId) {
                $treeLists = '<div class="organogram-jstree"><ul class="treeview-animated-list mb-3">';
                $treeLists = $this->generateOrganogramTreeviewList($hierarchicalOrganogramData, $treeLists, [], $name);
                $treeLists .= '</ul></div>';
                // return $treeLists;
            // });
        }
        
        return $treeLists;
    }

    public static function clearCache($cacheKey  = "")
    {
        if(!empty($cacheKey)) {
            if (Cache::has($cacheKey)) {
                Cache::forget($cacheKey);
            }
        } else {
            $cacheKey  = "organograms";
            $cacheKey0 = $cacheKey . '0';
            $cacheKey1 = $cacheKey . '1';
            // Clear the specific cache.
            if (Cache::has($cacheKey0)) {
                Cache::forget($cacheKey0);
            }
            if (Cache::has($cacheKey1)) {
                Cache::forget($cacheKey1);
            }
            if (Cache::has('organograms-pluck')) {
                Cache::forget('organograms-pluck');
            }
        }
        
    }

    /**
     * Get common dropdown data to populate dropdown in organogram form
     */
    public static function getCommonMasterData($mode, $organogramId) 
    {
        $lang = config('app.locale');
        $name = "name_{$lang}";
        $data['officeTypes'] = getOfficeType();
        $data['parentOffice'] = Organogram::active()->pluck($name, "id");
        if(auth()->user()->organization_id == config('app.organization_id_dae')) {
            $data['divisions'] = Region::getRegionsListArray();
        } else {
            $data['divisions'] = Division::getDivisionListArray();
        }
        
        $data['districts'] = [];
        $data['upazilla'] = [];
        $data['parentId'] = null;
        $data['unions'] = [];
        
        if($mode === 'edit') {
            $data['organogram'] = Organogram::find($organogramId);
            $data['districts'] = District::getDistrictListByDivisionId($data['organogram']->division_region_id);
            $data['upazilla'] = ThanaUpazila::getDistrictWIseThanaUpazillaListWithKeyValuePair($data['organogram']->district_id);
            $data['unions'] = UnionWard::getUnionListByUpazilaId($data['organogram']->upazila_id);
        } else {
            //$data['upazilla'] = ThanaUpazila::getDistrictWIseThanaUpazillaListWithKeyValuePair();
            $data['parentId'] = $organogramId;
        }

        return $data;
    }

    /**
     * Get organogram list as key value associative array
     */
    public static function getOrganogramLists ()
    {
        $lang = config('app.locale');
        $name = "name_{$lang}";

        $cacheKey  = "organograms-pluck";
        $cacheTime = 60 * 24 * 30; //30 days in minutes = minutes x hours x days

        $lists = Cache::remember($cacheKey, $cacheTime, function () use($name) {
            return Organogram::active()->pluck($name, 'id');
        });
        return $lists;
    }

    
    /**
     * Get Organogram Node Information.
     *
     * @param mixed   $nodes    Organogram Nodes
     * @param array   $result   Organogram Result
     * @param integer $depth    Count the Organogram Node iteration
     *
     * @return array
     */
    public function getOrganogramNodes($nodes, &$result, $depth = 0)
    {
        // Loop through them
        foreach ($nodes as $orgValue) {
            // Add organogram Node. Don't forget the dashes in front. Use ID as index
            $result[$orgValue['id']] = str_repeat('-', $depth) . ' ' . $orgValue['name_bn'];

            // Go deeper - let's look for "children" of current organogram Node
            if(!empty($orgValue['items']))
                $this->getOrganogramNodes($orgValue['items'], $result, $depth + 1);
        }

        return $result;
    }

    /**
     * Organogram Dropdown Information.
     *
     * @return array
     */
    public function organogramDropdown($organizationId = '')
    {
        $organogramData = $this->active()->organogram();
        if ( !empty(auth()->user()->organization_id) ) {
            $organizationId = auth()->user()->organization_id;
        }
        
        $organogramData = $organogramData->where ('organization_id', $organizationId);
        // Get organogram nodes data. In this case it's eloquent.
        $organogramData = $organogramData->get();
        $organogramTreeData = $this->makeOrganogramTreeArray ($organogramData->toArray());

        // If you don't have the eloquent model you can use DB query builder:
        // Prepare an empty array for $id => $formattedVal storing
        $result = [];

        // Start by root organogram nodes
        return $this->getOrganogramNodes($organogramTreeData, $result);
    }

}
