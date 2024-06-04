<template>
    <a-tree
      class="draggable-tree"
      draggable
      block-node
      :tree-data="gData"
      @dragenter="onDragEnter"
      @drop="onDrop"

    /> 
    <a-directory-tree
    v-model:expandedKeys="expandedKeys"
    v-model:selectedKeys="selectedKeys"
    multiple
    :tree-data="gData"
  ></a-directory-tree>
    <!-- @expand="handleExpand"
      :expanded-keys="expandedKeys" -->
  </template>
  <script setup>
  import { ref} from 'vue';
  const x = 3;
  const y = 2;
  const z = 1;
  const genData = []; 


  const generateData = (_level, _preKey, _tns) => {
    const preKey = _preKey || '0';
    const tns = _tns || genData;
    const children = [];
    for (let i = 0; i < x; i++) {
      const key = `${preKey}-${i}`;
      tns.push({
        title: key,
        key,
      });
      if (i < y) {
        children.push(key);
      }
    }
    if (_level < 0) {
      return tns;
    }
    const level = _level - 1;
    children.forEach((key, index) => {
      tns[index].children = [];
      return generateData(level, key, tns[index].children);
    });
  };
  generateData(z);
  const gData = ref(genData);
  const onDragEnter = info => {
    console.log(info);
    // expandedKeys 需要展开时
    // expandedKeys.value = info.expandedKeys;
  };
  const onDrop = info => {
    console.log(info);
    const dropKey = info.node.key;
    const dragKey = info.dragNode.key;
    const dropPos = info.node.pos.split('-');
    const dropPosition = info.dropPosition - Number(dropPos[dropPos.length - 1]);
    const loop = (data, key, callback) => {
      data.forEach((item, index) => {
        if (item.key === key) {
          return callback(item, index, data);
        }
        if (item.children) {
          return loop(item.children, key, callback);
        }
      });
    };
    const data = [...gData.value];
  
    // Find dragObject
    let dragObj;
    loop(data, dragKey, (item, index, arr) => {
      arr.splice(index, 1);
      dragObj = item;
    });
    if (!info.dropToGap) {
      // Drop on the content
      loop(data, dropKey, item => {
        item.children = item.children || [];
        /// where to insert 示例添加到头部，可以是随意位置
        item.children.unshift(dragObj);
      });
    } else if (
      (info.node.children || []).length > 0 &&
      // Has children
      info.node.expanded &&
      // Is expanded
      dropPosition === 1 // On the bottom gap
    ) {
      loop(data, dropKey, item => {
        item.children = item.children || [];
        // where to insert 示例添加到头部，可以是随意位置
        item.children.unshift(dragObj);
      });
    } else {
      let ar = [];
      let i = 0;
      loop(data, dropKey, (_item, index, arr) => {
        ar = arr;
        i = index;
      });
      if (dropPosition === -1) {
        ar.splice(i, 0, dragObj);
      } else {
        ar.splice(i + 1, 0, dragObj);
      }
    }
    gData.value = data;
  };


//   const handleExpand = (keys, { expanded, node }) => {
//   // node.parent add from 3.0.0-alpha.10
//   const tempKeys = ((node.parent ? node.parent.children : treeData) || []).map(({ key }) => key);
//   if (expanded) {
//     expandedKeys.value = difference(keys, tempKeys).concat(node.key);
//   } else {
//     expandedKeys.value = keys;
//   }
// };






  </script>