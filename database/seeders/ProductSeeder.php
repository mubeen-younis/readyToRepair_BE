<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['id' => 'product-1', 'name' => '7 Hole Drive Wheel Forklift Durable Polyurethane 343into140into80', 'image' => '/images/products/7 hole drive wheel forklift durable polyurethane 343into140into80.jpeg', 'slug' => '7-hole-drive-wheel-forklift-durable-polyurethane-343into140into80', 'price' => 75000],
            ['id' => 'product-2', 'name' => 'Ac Motor Encoder 34mm 45mm', 'image' => '/images/products/Ac motor encoder 34mm 45mm.jpeg', 'slug' => 'ac-motor-encoder-34mm-45mm', 'price' => 28000],
            ['id' => 'product-3', 'name' => 'Accessories Gas Spring For Control Handle Stand On Pallet Truck Electric Stacker', 'image' => '/images/products/Accessories gas spring for control handle stand on pallet truck Electric stacker.jpeg', 'slug' => 'accessories-gas-spring-for-control-handle-stand-on-pallet-truck-electric-stacker', 'price' => 12800],
            ['id' => 'product-4', 'name' => 'Aebs200 124000 000 Heavy Duty Pu Wheel Forklift Tyre 25080200mm (12 Holes) Casters For Material Handling Equipment', 'image' => '/images/products/AEBS200-124000-000 Heavy Duty PU Wheel Forklift Tyre 25080200mm (12 Holes) Casters for Material Handling Equipment.jpeg', 'slug' => 'aebs200-124000-000-heavy-duty-pu-wheel-forklift-tyre-25080200mm-12-holes-casters-for-material-handling-equipment', 'price' => 58000],
            ['id' => 'product-5', 'name' => 'Air Filter K1330 Air For Hangcha Heli 3ton 2ton Forklift', 'image' => '/images/products/Air filter K1330 Air for Hangcha Heli 3Ton 2Ton Forklift.jpeg', 'slug' => 'air-filter-k1330-air-for-hangcha-heli-3ton-2ton-forklift', 'price' => 5800],
            ['id' => 'product-6', 'name' => 'Battery Bank 48v Dc Deep Cycle 510amp 545amp', 'image' => '/images/products/Battery bank 48V DC deep Cycle 510Amp 545Amp.jpeg', 'slug' => 'battery-bank-48v-dc-deep-cycle-510amp-545amp', 'price' => 1950000],
            ['id' => 'product-7', 'name' => 'Brake Assembly For Forklift Front Wheels', 'image' => '/images/products/Brake assembly for forklift front wheels.jpeg', 'slug' => 'brake-assembly-for-forklift-front-wheels', 'price' => 36000],
            ['id' => 'product-8', 'name' => 'Brake Wheel Cylinder For Forklift', 'image' => '/images/products/Brake wheel cylinder for forklift.jpeg', 'slug' => 'brake-wheel-cylinder-for-forklift', 'price' => 5800],
            ['id' => 'product-9', 'name' => 'Bt Electric Stacker Magnetic Contactor 24v Dc', 'image' => '/images/products/BT Electric stacker Magnetic contactor 24V DC.jpeg', 'slug' => 'bt-electric-stacker-magnetic-contactor-24v-dc', 'price' => 17600],
            ['id' => 'product-10', 'name' => 'Cdd12 Electric Stacker Wheels Complete Set', 'image' => '/images/products/CDD12 Electric stacker wheels complete set.jpeg', 'slug' => 'cdd12-electric-stacker-wheels-complete-set', 'price' => 18400],
            ['id' => 'product-11', 'name' => 'D51w8 10611 Spare Parts Bearing 4510040mm Material Handling Machinery Forklift Mast Bearing', 'image' => '/images/products/D51W8-10611 Spare Parts Bearing 4510040mm Material Handling Machinery Forklift Mast Bearing.jpeg', 'slug' => 'd51w8-10611-spare-parts-bearing-4510040mm-material-handling-machinery-forklift-mast-bearing', 'price' => 13600],
            ['id' => 'product-12', 'name' => 'Dc Motor Curtis Control Card 48v 80v', 'image' => '/images/products/Dc motor Curtis control card 48v-80v.jpeg', 'slug' => 'dc-motor-curtis-control-card-48v-80v', 'price' => 350000],
            ['id' => 'product-13', 'name' => 'Ed250p 1', 'image' => '/images/products/ED250P-1.jpeg', 'slug' => 'ed250p-1', 'price' => 15200],
            ['id' => 'product-14', 'name' => 'Electri Stacker Balance Wheel Assembly', 'image' => '/images/products/Electri stacker balance wheel assembly.jpeg', 'slug' => 'electri-stacker-balance-wheel-assembly', 'price' => 23000],
            ['id' => 'product-15', 'name' => 'Electri Stacker Wheels Complete Set', 'image' => '/images/products/Electri stacker wheels complete set.jpeg', 'slug' => 'electri-stacker-wheels-complete-set', 'price' => 20000],
            ['id' => 'product-16', 'name' => 'Electric Stacker Load Wheel 70into85', 'image' => '/images/products/Electric stacker load wheel 70into85.jpeg', 'slug' => 'electric-stacker-load-wheel-70into85', 'price' => 9800],
            ['id' => 'product-17', 'name' => 'Electric Stacker Power Pallet Hydraulic Motor Magnetic Contactor 24v Dc', 'image' => '/images/products/Electric stacker Power Pallet Hydraulic Motor Magnetic contactor 24V DC.jpeg', 'slug' => 'electric-stacker-power-pallet-hydraulic-motor-magnetic-contactor-24v-dc', 'price' => 20800],
            ['id' => 'product-18', 'name' => 'Electric Stacker Steering Control Card 24v', 'image' => '/images/products/Electric stacker steering control card 24v.jpeg', 'slug' => 'electric-stacker-steering-control-card-24v', 'price' => 21600],
            ['id' => 'product-19', 'name' => 'Engine Type Forklift Alternator 24v', 'image' => '/images/products/Engine type forklift alternator 24v.jpeg', 'slug' => 'engine-type-forklift-alternator-24v', 'price' => 22400],
            ['id' => 'product-20', 'name' => 'Ep Electric Stacker Control Handle Tiller Assembly', 'image' => '/images/products/EP electric stacker Control handle tiller assembly.jpeg', 'slug' => 'ep-electric-stacker-control-handle-tiller-assembly', 'price' => 152000],
            ['id' => 'product-21', 'name' => 'Forklift Charger Control Board Cia80100038 Oem Battery Charger Pcb For Linde & Jungheinrich Electric Forklift Charger', 'image' => '/images/products/Forklift Charger Control Board CIA80100038  OEM Battery Charger PCB for Linde & Jungheinrich Electric Forklift Charger.jpeg', 'slug' => 'forklift-charger-control-board-cia80100038-oem-battery-charger-pcb-for-linde-jungheinrich-electric-forklift-charger', 'price' => 84000],
            ['id' => 'product-22', 'name' => 'Forklift Spare Parts Ignition Switch Jk406c Is Suitable For Heli Hangcha Tcm Hyundai Jack', 'image' => '/images/products/Forklift spare parts ignition switch jk406c is suitable for Heli Hangcha TCM Hyundai Jack.jpeg', 'slug' => 'forklift-spare-parts-ignition-switch-jk406c-is-suitable-for-heli-hangcha-tcm-hyundai-jack', 'price' => 24000],
            ['id' => 'product-23', 'name' => 'Hand Pallet Truck Drive Wheel 50into175 Nylon', 'image' => '/images/products/Hand pallet truck drive wheel 50into175 nylon.jpeg', 'slug' => 'hand-pallet-truck-drive-wheel-50into175-nylon', 'price' => 3500],
            ['id' => 'product-24', 'name' => 'Hand Pallet Truck Drive Wheel 50into175 Pu Local', 'image' => '/images/products/Hand pallet truck drive wheel 50into175 pu local.jpeg', 'slug' => 'hand-pallet-truck-drive-wheel-50into175-pu-local', 'price' => 4000],
            ['id' => 'product-25', 'name' => 'Hand Pallet Truck Load Wheel 70into80 Eatalon', 'image' => '/images/products/Hand pallet truck Load wheel 70into80 Eatalon.jpeg', 'slug' => 'hand-pallet-truck-load-wheel-70into80-eatalon', 'price' => 2100],
            ['id' => 'product-26', 'name' => 'Hand Pallet Truck Load Wheel 70into80 Etalon', 'image' => '/images/products/Hand pallet truck Load wheel 70into80 etalon.jpeg', 'slug' => 'hand-pallet-truck-load-wheel-70into80-etalon', 'price' => 2600],
            ['id' => 'product-27', 'name' => 'Hand Pallet Truck Load Wheel 70into80 Nylon', 'image' => '/images/products/Hand pallet truck Load wheel 70into80 nylon.jpeg', 'slug' => 'hand-pallet-truck-load-wheel-70into80-nylon', 'price' => 1800],
            ['id' => 'product-28', 'name' => 'Hand Pallet Truck Load Wheel 70into80 Pu', 'image' => '/images/products/Hand pallet truck Load wheel 70into80 PU.jpeg', 'slug' => 'hand-pallet-truck-load-wheel-70into80-pu', 'price' => 2200],
            ['id' => 'product-29', 'name' => 'Hangcha Electric Stacker Control Handle Tiller Assembly', 'image' => '/images/products/Hangcha electric stacker Control handle tiller assembly (2).jpeg', 'slug' => 'hangcha-electric-stacker-control-handle-tiller-assembly', 'price' => 156000],
            ['id' => 'product-30', 'name' => 'Hangcha Electric Stacker Control Handle Tiller Assembly', 'image' => '/images/products/Hangcha electric stacker Control handle tiller assembly.jpeg', 'slug' => 'hangcha-electric-stacker-control-handle-tiller-assembly-product-30', 'price' => 149800],
            ['id' => 'product-31', 'name' => 'Heli Electri Stacker Zaipi Control Card 24v', 'image' => '/images/products/Heli electri stacker zaipi control card 24v.jpeg', 'slug' => 'heli-electri-stacker-zaipi-control-card-24v', 'price' => 325600],
            ['id' => 'product-32', 'name' => 'Heli Electric Stacker Control Handle Tiller Assembly', 'image' => '/images/products/Heli electric stacker Control handle tiller assembly.jpeg', 'slug' => 'heli-electric-stacker-control-handle-tiller-assembly', 'price' => 126400],
            ['id' => 'product-33', 'name' => 'Heli Hangcha Fuse Clip S100s S150a S200a S250a S300a S400a For Forklift Parts Attachment', 'image' => '/images/products/Heli hangcha fuse clip S100S S150A S200A S250A S300A S400A for Forklift parts attachment.jpeg', 'slug' => 'heli-hangcha-fuse-clip-s100s-s150a-s200a-s250a-s300a-s400a-for-forklift-parts-attachment', 'price' => 25600],
            ['id' => 'product-34', 'name' => 'Hudraulic Pump For 3ton 3.5ton 4 Ton For Heli Hangcha Jack Forklift', 'image' => '/images/products/Hudraulic pump for 3Ton 3.5Ton 4 ton for heli hangcha jack forklift.jpeg', 'slug' => 'hudraulic-pump-for-3ton-3-5ton-4-ton-for-heli-hangcha-jack-forklift', 'price' => 26400],
            ['id' => 'product-35', 'name' => 'Hydraulic Power Pack 24 For Electric Stacker, Power Pallet', 'image' => '/images/products/Hydraulic power pack 24 for Electric stacker, power pallet.jpeg', 'slug' => 'hydraulic-power-pack-24-for-electric-stacker-power-pallet', 'price' => 127200],
            ['id' => 'product-36', 'name' => 'Jaunghenrich Forklift Tiller And Control Assembly', 'image' => '/images/products/Jaunghenrich forklift tiller and control assembly.jpeg', 'slug' => 'jaunghenrich-forklift-tiller-and-control-assembly', 'price' => 27200],
            ['id' => 'product-37', 'name' => 'Jungheinrich Electric Stacker Control Head Handle Uper Part', 'image' => '/images/products/Jungheinrich  Electric stacker control head handle uper part.jpeg', 'slug' => 'jungheinrich-electric-stacker-control-head-handle-uper-part', 'price' => 28000],
            ['id' => 'product-38', 'name' => 'Jungheinrich Forklift Spare Parts Sensor 51260975 50430956 Used By Warehouse Equipment Replacement Parts', 'image' => '/images/products/Jungheinrich Forklift Spare Parts Sensor 51260975 50430956 Used by Warehouse Equipment Replacement Parts.jpeg', 'slug' => 'jungheinrich-forklift-spare-parts-sensor-51260975-50430956-used-by-warehouse-equipment-replacement-parts', 'price' => 28000],
            ['id' => 'product-39', 'name' => 'Lithium Battery Deep Cycle 24v 240amp', 'image' => '/images/products/Lithium battery Deep cycle 24v 240Amp.jpeg', 'slug' => 'lithium-battery-deep-cycle-24v-240amp', 'price' => 165000],
            ['id' => 'product-40', 'name' => 'Magnetic Main Contactor Type Sw80 Voltage 24v Dc', 'image' => '/images/products/Magnetic main contactor type SW80 Voltage 24v DC.jpeg', 'slug' => 'magnetic-main-contactor-type-sw80-voltage-24v-dc', 'price' => 29600],
            ['id' => 'product-41', 'name' => 'Main Magnetic Contactor 48v Co', 'image' => '/images/products/Main magnetic Contactor 48V CO.jpeg', 'slug' => 'main-magnetic-contactor-48v-co', 'price' => 30400],
            ['id' => 'product-42', 'name' => 'Rema Battery Charger Battery Connector 160amp', 'image' => '/images/products/Rema battery charger battery connector 160Amp.jpeg', 'slug' => 'rema-battery-charger-battery-connector-160amp', 'price' => 31200],
            ['id' => 'product-43', 'name' => 'Rema Battery Charger Connectors 320amp', 'image' => '/images/products/Rema battery charger connectors 320amp.jpeg', 'slug' => 'rema-battery-charger-connectors-320amp', 'price' => 32000],
            ['id' => 'product-44', 'name' => 'Rema Charger Battery Connector 160amp With Wire', 'image' => '/images/products/Rema charger battery connector 160Amp with wire.jpeg', 'slug' => 'rema-charger-battery-connector-160amp-with-wire', 'price' => 32800],
            ['id' => 'product-45', 'name' => 'Rema Charger Battery Connector 80amp', 'image' => '/images/products/Rema charger battery connector 80amp.jpeg', 'slug' => 'rema-charger-battery-connector-80amp', 'price' => 33600],
            ['id' => 'product-46', 'name' => 'Steering Assembly For 02 Ton 2.5 Ton 03 Ton 3.5 Ton Forklift Hangcha Heli Tcm Jack', 'image' => '/images/products/Steering assembly for 02 Ton 2.5 Ton 03 Ton 3.5 Ton Forklift Hangcha Heli TCM Jack.jpeg', 'slug' => 'steering-assembly-for-02-ton-2-5-ton-03-ton-3-5-ton-forklift-hangcha-heli-tcm-jack', 'price' => 34400],
            ['id' => 'product-47', 'name' => 'Tl0022c Clutch Pressure Plate For Hangcha Cpc30 Forklift 3ton Spare Parts', 'image' => '/images/products/TL0022C Clutch pressure plate for Hangcha CPC30 Forklift 3Ton spare parts.jpeg', 'slug' => 'tl0022c-clutch-pressure-plate-for-hangcha-cpc30-forklift-3ton-spare-parts', 'price' => 35200],
        ];

        foreach ($products as $product) {
            Product::query()->updateOrCreate(
                ['id' => $product['id']],
                [
                    'name' => $product['name'],
                    'image' => $product['image'],
                    'slug' => $product['slug'],
                    'price' => $product['price'],
                ],
            );
        }
    }
}
